<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $city = '';
    public string $postal_code = '';
    public string $country = '';
    public string $shipping_address = '';
    public string $shipping_city = '';
    public string $shipping_postal_code = '';
    public string $shipping_country = '';
    public bool $use_different_shipping = false;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->first_name = $user->first_name ?? '';
        $this->last_name = $user->last_name ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->city = $user->city ?? '';
        $this->postal_code = $user->postal_code ?? '';
        $this->country = $user->country ?? 'France';
        $this->shipping_address = $user->shipping_address ?? '';
        $this->shipping_city = $user->shipping_city ?? '';
        $this->shipping_postal_code = $user->shipping_postal_code ?? '';
        $this->shipping_country = $user->shipping_country ?? '';
        $this->use_different_shipping = $user->hasShippingAddress();
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'country' => ['nullable', 'string', 'max:255'],
        ];

        if ($this->use_different_shipping) {
            $rules['shipping_address'] = ['nullable', 'string', 'max:255'];
            $rules['shipping_city'] = ['nullable', 'string', 'max:255'];
            $rules['shipping_postal_code'] = ['nullable', 'string', 'max:10'];
            $rules['shipping_country'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $this->validate($rules);

        // Clear shipping address if not using different shipping
        if (!$this->use_different_shipping) {
            $validated['shipping_address'] = null;
            $validated['shipping_city'] = null;
            $validated['shipping_postal_code'] = null;
            $validated['shipping_country'] = null;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
