<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Configuration PayPal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">🔍 Test Configuration PayPal</h1>
            
            <!-- Status -->
            <div class="mb-6 p-4 rounded-lg {{ strpos($results['status'], '✅') !== false ? 'bg-green-100 border border-green-400' : 'bg-red-100 border border-red-400' }}">
                <p class="text-lg font-semibold {{ strpos($results['status'], '✅') !== false ? 'text-green-800' : 'text-red-800' }}">
                    {{ $results['status'] }}
                </p>
            </div>

            <!-- Configuration -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3 text-gray-700">Configuration</h2>
                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium">Mode:</span>
                        <span class="font-mono {{ $results['configuration']['mode'] === 'sandbox' ? 'text-green-600' : 'text-blue-600' }}">
                            {{ $results['configuration']['mode'] ?? 'NOT SET' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Client ID configuré:</span>
                        <span class="{{ $results['configuration']['client_id_configured'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ $results['configuration']['client_id_configured'] ? '✅ Oui' : '❌ Non' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Secret configuré:</span>
                        <span class="{{ $results['configuration']['secret_configured'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ $results['configuration']['secret_configured'] ? '✅ Oui' : '❌ Non' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Client ID (partiel):</span>
                        <span class="font-mono text-sm text-gray-600">{{ $results['configuration']['client_id'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Test Results -->
            @if(isset($results['test_order']))
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3 text-gray-700">Résultat du test</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    @if($results['test_order']['success'])
                        <div class="space-y-2">
                            <p class="text-green-600 font-semibold">✅ {{ $results['test_order']['message'] }}</p>
                            <div class="bg-white rounded p-3 border border-green-200">
                                <p class="text-sm font-medium text-gray-700">Order ID:</p>
                                <p class="font-mono text-sm text-gray-600">{{ $results['test_order']['order_id'] }}</p>
                            </div>
                            <p class="text-sm text-gray-600 mt-3">
                                ✨ Votre configuration PayPal fonctionne correctement ! 
                                Vous pouvez maintenant tester le paiement complet sur votre site.
                            </p>
                        </div>
                    @else
                        <div class="text-red-600">
                            <p class="font-semibold mb-2">❌ Erreur lors du test:</p>
                            <pre class="bg-red-50 p-3 rounded text-sm overflow-x-auto">{{ $results['test_order']['error'] }}</pre>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Error Details -->
            @if(isset($results['error']))
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3 text-red-700">Erreur</h2>
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <pre class="text-sm text-red-800 whitespace-pre-wrap">{{ $results['error'] }}</pre>
                </div>
            </div>
            @endif

            <!-- Instructions -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3 text-gray-700">📝 Instructions</h2>
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 space-y-3">
                    <p class="text-sm text-gray-700">
                        <strong>1. Obtenir vos clés sandbox PayPal :</strong>
                    </p>
                    <ul class="list-disc list-inside text-sm text-gray-600 ml-4 space-y-1">
                        <li>Allez sur <a href="https://developer.paypal.com/" target="_blank" class="text-blue-600 hover:underline">developer.paypal.com</a></li>
                        <li>Connectez-vous ou créez un compte</li>
                        <li>Accédez à "My Apps & Credentials"</li>
                        <li>Sous l'onglet "Sandbox", créez une application</li>
                        <li>Copiez le "Client ID" et le "Secret"</li>
                    </ul>

                    <p class="text-sm text-gray-700 mt-3">
                        <strong>2. Configurer dans votre .env :</strong>
                    </p>
                    <pre class="bg-gray-800 text-green-400 p-3 rounded text-sm overflow-x-auto">PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=votre_client_id_ici
PAYPAL_SECRET=votre_secret_ici</pre>

                    <p class="text-sm text-gray-700 mt-3">
                        <strong>3. Redémarrer votre serveur :</strong>
                    </p>
                    <pre class="bg-gray-800 text-green-400 p-3 rounded text-sm">php artisan config:clear
php artisan serve</pre>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <a href="/paypal/test" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    🔄 Retester
                </a>
                <a href="/" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold">
                    ← Retour au site
                </a>
                <a href="https://developer.paypal.com/dashboard/" target="_blank" class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-semibold">
                    🔑 PayPal Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>
