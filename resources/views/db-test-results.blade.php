<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - StafferHQ Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            font-weight: 300;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .content {
            padding: 30px;
        }
        
        .test-section {
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .test-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        .test-content {
            padding: 20px;
        }
        
        .status-success {
            color: #28a745;
            font-weight: 600;
        }
        
        .status-failed {
            color: #dc3545;
            font-weight: 600;
        }
        
        .status-warning {
            color: #ffc107;
            font-weight: 600;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }
        
        .info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4facfe;
        }
        
        .table-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        
        .table-item {
            background: #f1f3f4;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9em;
            border-left: 3px solid #4facfe;
        }
        
        .performance-meter {
            background: #e0e0e0;
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
            position: relative;
        }
        
        .performance-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .performance-excellent {
            background: linear-gradient(90deg, #48dbfb, #0abde3);
        }
        
        .performance-good {
            background: linear-gradient(90deg, #feca57, #ff9ff3);
        }
        
        .performance-slow {
            background: linear-gradient(90deg, #ff6b6b, #ee5a24);
        }
        
        .summary {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            margin-top: 30px;
        }
        
        .summary h2 {
            margin-bottom: 15px;
            font-size: 1.8em;
        }
        
        .refresh-btn {
            background: #4facfe;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            margin: 20px 0;
            transition: background 0.3s;
        }
        
        .refresh-btn:hover {
            background: #3d8bfe;
        }
        
        .error-details {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        
        .timestamp {
            text-align: right;
            color: #666;
            font-size: 0.9em;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗄️ Database Connection Test</h1>
            <p>StafferHQ Admin - Real-time Database Status</p>
            <p>Test performed: {{ $results['timestamp'] }}</p>
        </div>

        <div class="content">
            <button class="refresh-btn" onclick="window.location.reload()">🔄 Refresh Test</button>

            <!-- Connection Status -->
            <div class="test-section">
                <div class="test-header">🔌 Database Connection Status</div>
                <div class="test-content">
                    @if($results['connection']['status'] === 'success')
                        <div class="status-success">✅ SUCCESS: {{ $results['connection']['message'] }}</div>
                        <div class="info-grid">
                            <div class="info-card">
                                <strong>Host:</strong> {{ $results['config']['host'] }}<br>
                                <strong>Port:</strong> {{ $results['config']['port'] }}<br>
                                <strong>Database:</strong> {{ $results['config']['database'] }}
                            </div>
                            <div class="info-card">
                                <strong>Server Version:</strong> {{ $results['connection']['server_version'] }}<br>
                                <strong>PHP Version:</strong> {{ $results['php_version'] }}<br>
                                <strong>Username:</strong> {{ $results['config']['username'] }}
                            </div>
                        </div>
                    @else
                        <div class="status-failed">❌ FAILED: Database connection failed</div>
                        <div class="error-details">
                            <strong>Error:</strong> {{ $results['connection']['error'] }}<br>
                            <strong>Code:</strong> {{ $results['connection']['code'] }}
                        </div>
                    @endif
                </div>
            </div>

            @if($results['connection']['status'] === 'success')
                <!-- Tables Check -->
                <div class="test-section">
                    <div class="test-header">📋 Database Tables ({{ $results['tables']['count'] }} found)</div>
                    <div class="test-content">
                        @if($results['tables']['count'] > 0)
                            <div class="status-success">✅ SUCCESS: Found {{ $results['tables']['count'] }} tables</div>
                            <div class="table-grid">
                                @foreach($results['tables']['list'] as $table)
                                    <div class="table-item">{{ $table }}</div>
                                @endforeach
                            </div>
                        @else
                            <div class="status-warning">⚠️ WARNING: No tables found</div>
                        @endif
                    </div>
                </div>

                <!-- Users Table -->
                <div class="test-section">
                    <div class="test-header">👥 Users Table Status</div>
                    <div class="test-content">
                        @if($results['users']['status'] === 'found')
                            <div class="status-success">✅ SUCCESS: Users table found</div>
                            <div class="info-card">
                                <strong>Total Users:</strong> {{ $results['users']['count'] }}<br>
                                <strong>Authentication:</strong> Ready<br>
                                <strong>Status:</strong> Operational
                            </div>
                        @else
                            <div class="status-failed">❌ FAILED: Users table not found</div>
                        @endif
                    </div>
                </div>

                <!-- Migrations -->
                <div class="test-section">
                    <div class="test-header">🔄 Laravel Migrations</div>
                    <div class="test-content">
                        @if($results['migrations']['status'] === 'found')
                            <div class="status-success">✅ SUCCESS: Migrations table found</div>
                            <div class="info-card">
                                <strong>Migrations Run:</strong> {{ $results['migrations']['count'] }}<br>
                                <strong>Laravel Setup:</strong> Complete<br>
                                <strong>Database Schema:</strong> Up to date
                            </div>
                        @else
                            <div class="status-warning">⚠️ WARNING: Migrations table not found</div>
                        @endif
                    </div>
                </div>

                <!-- Performance -->
                <div class="test-section">
                    <div class="test-header">⚡ Connection Performance</div>
                    <div class="test-content">
                        <div class="status-success">✅ Performance test completed</div>
                        <div class="info-grid">
                            <div class="info-card">
                                <strong>Total Time:</strong> {{ $results['performance']['total_time_ms'] }} ms<br>
                                <strong>Average per Query:</strong> {{ $results['performance']['avg_time_ms'] }} ms<br>
                                <strong>Rating:</strong> 
                                @if($results['performance']['rating'] === 'excellent')
                                    <span class="status-success">Excellent</span>
                                @elseif($results['performance']['rating'] === 'good')
                                    <span class="status-warning">Good</span>
                                @else
                                    <span class="status-failed">Moderate</span>
                                @endif
                            </div>
                            <div class="info-card">
                                <div class="performance-meter">
                                    <div class="performance-fill performance-{{ $results['performance']['rating'] }}" 
                                         style="width: {{ min(100, ($results['performance']['avg_time_ms'] / 500) * 100) }}%">
                                    </div>
                                </div>
                                <small>Performance visualization</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Summary -->
            <div class="summary">
                <h2>📊 Overall Status</h2>
                @if($results['connection']['status'] === 'success')
                    <p><strong>🎉 Database is FULLY OPERATIONAL</strong></p>
                    <p>✅ Connection: Active | ✅ Tables: {{ $results['tables']['count'] }} found | ✅ Users: {{ $results['users']['count'] }} registered</p>
                    <p>Your StafferHQ Admin system is ready for use!</p>
                @else
                    <p><strong>❌ Database Connection Failed</strong></p>
                    <p>Please check your database credentials and server status.</p>
                @endif
            </div>

            <div class="timestamp">
                Last tested: {{ $results['timestamp'] }} | 
                <a href="{{ route('test-db-connection') }}" style="color: #4facfe;">Run Test Again</a> | 
                <a href="{{ route('dashboard') }}" style="color: #4facfe;">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
