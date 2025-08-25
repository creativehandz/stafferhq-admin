<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="w        function clearResults() {
            document.getElementById('results').innerHTML = '';
        }

        function createTestUser() {
            document.getElementById('result').innerHTML = '<div class="result">Creating test user...</div>';
            
            axios.post('/create-test-user')
            .then(response => {
                document.getElementById('result').innerHTML = '<div class="result success">Test user created and logged in! Refreshing page...</div>';
                setTimeout(() => {
                    location.reload();
                }, 1500);
            })
            .catch(error => {
                console.error('Error creating test user:', error);
                document.getElementById('result').innerHTML = '<div class="result error">Failed to create test user: ' + JSON.stringify(error.response?.data || error.message) + '</div>';
            });
        }h=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout Test</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 15px; border: 1px solid #ccc; background: #f9f9f9; }
        .error { border-color: red; background: #ffe6e6; }
        .success { border-color: green; background: #e6ffe6; }
        button { padding: 10px 20px; margin: 10px; background: #007cba; color: white; border: none; cursor: pointer; }
        pre { white-space: pre-wrap; word-wrap: break-word; font-size: 12px; }
        .info { background: #e6f3ff; border-color: #007cba; }
    </style>
</head>
<body>
    <h1>Checkout Test Page</h1>
    
    <div class="result info">
        <h3>About billingDetails:</h3>
        <p><strong>billingDetails</strong> is a <strong>database column</strong> in the <strong>buyer_checkout</strong> table.</p>
        <ul>
            <li><strong>Database Column:</strong> billing_details (type: text)</li>
            <li><strong>Purpose:</strong> Stores billing information as JSON</li>
            <li><strong>Expected Format:</strong> JSON object with name, email, address, etc.</li>
            <li><strong>Laravel Model:</strong> Cast as array in BuyerCheckout model</li>
        </ul>
    </div>

    <div class="result info">
        <h3>Authentication Status:</h3>
        <p><strong>Current User:</strong> 
            @auth
                {{ auth()->user()->name }} ({{ auth()->user()->email }})
            @else
                <span style="color: red;">Not logged in - Checkout requires authentication!</span>
            @endauth
        </p>
        @guest
        <button onclick="createTestUser()" style="background: #28a745;">Create & Login Test User</button>
        <p><em>The checkout endpoint requires an authenticated user. Please login first.</em></p>
        @endguest
    </div>
    
    <h3>Test Data Being Sent:</h3>
    <pre id="testData"></pre>
    
    <div id="result"></div>
    
    <button onclick="testCheckout()">Test Checkout API</button>
    <button onclick="clearResults()">Clear Results</button>

    <script>
        // Set up axios with CSRF token
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }
        
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        const testData = {
            packageName: 'Premium Package',
            packageDescription: 'This is a test premium package with extended features',
            packagePrice: 200,
            deliveryTime: '3 days',
            gigId: 70,
            billingDetails: {
                name: 'Test User',
                email: 'test@example.com',
                address: '123 Test Street',
                city: 'Test City',
                state: 'Test State',
                zip: '12345',
                phone: '+1234567890'
            }
        };

        // Display the test data
        document.getElementById('testData').textContent = JSON.stringify(testData, null, 2);
        
        function testCheckout() {
            document.getElementById('result').innerHTML = '<div class="result">Testing...</div>';
            
            console.log('Sending data:', testData);
            
            axios.post('/checkout', testData)
                .then(response => {
                    console.log('Success:', response.data);
                    document.getElementById('result').innerHTML = 
                        '<div class="result success"><h3>✅ Success!</h3><pre>' + JSON.stringify(response.data, null, 2) + '</pre></div>';
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorDetails = {
                        status: error.response?.status,
                        statusText: error.response?.statusText,
                        message: error.response?.data?.message || error.message,
                        data: error.response?.data
                    };
                    document.getElementById('result').innerHTML = 
                        '<div class="result error"><h3>❌ Error!</h3><pre>' + JSON.stringify(errorDetails, null, 2) + '</pre></div>';
                });
        }

        function clearResults() {
            document.getElementById('result').innerHTML = '';
        }
    </script>
</body>
</html>
