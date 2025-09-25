<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Officials - Database Setup</title>
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .setup-card { margin-top: 50px; }
        .step { padding: 20px; border-left: 4px solid #007bff; margin-bottom: 20px; background: white; }
        .step.success { border-left-color: #28a745; }
        .step.error { border-left-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card setup-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-database mr-2"></i>SK Officials Database Setup</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            This page will help you set up the SK Officials database table.
                        </div>

                        <div id="setupSteps">
                            <div class="step" id="step1">
                                <h5><i class="fas fa-cog fa-spin mr-2"></i>Step 1: Checking Database Connection</h5>
                                <p>Verifying connection to the database...</p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-primary" id="startSetup">
                                <i class="fas fa-play mr-2"></i>Start Setup
                            </button>
                            <a href="../" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#startSetup').click(function() {
                startDatabaseSetup();
            });
        });

        function startDatabaseSetup() {
            $('#startSetup').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Setting up...');
            
            // Step 1: Check database connection
            updateStep(1, 'Checking Database Connection', 'Verifying connection to the database...', 'loading');
            
            $.ajax({
                url: 'setup_database.php?action=check_connection',
                method: 'GET',
                dataType: 'json',
                success: function(resp) {
                    if(resp.status === 'success') {
                        updateStep(1, 'Database Connection', 'Database connection successful!', 'success');
                        setTimeout(() => { setupTable(); }, 1000);
                    } else {
                        updateStep(1, 'Database Connection Failed', resp.msg, 'error');
                        $('#startSetup').prop('disabled', false).html('<i class="fas fa-redo mr-2"></i>Retry Setup');
                    }
                },
                error: function() {
                    updateStep(1, 'Database Connection Failed', 'Unable to connect to database. Please check your configuration.', 'error');
                    $('#startSetup').prop('disabled', false).html('<i class="fas fa-redo mr-2"></i>Retry Setup');
                }
            });
        }

        function setupTable() {
            // Add Step 2
            $('#setupSteps').append(`
                <div class="step" id="step2">
                    <h5><i class="fas fa-cog fa-spin mr-2"></i>Step 2: Creating SK Officials Table</h5>
                    <p>Creating the sk_officials table with sample data...</p>
                </div>
            `);

            $.ajax({
                url: 'setup_database.php?action=create_table',
                method: 'POST',
                dataType: 'json',
                success: function(resp) {
                    if(resp.status === 'success') {
                        updateStep(2, 'Table Creation Complete', 'SK Officials table created successfully with sample data!', 'success');
                        setTimeout(() => { finishSetup(); }, 1000);
                    } else {
                        updateStep(2, 'Table Creation Failed', resp.msg, 'error');
                        $('#startSetup').prop('disabled', false).html('<i class="fas fa-redo mr-2"></i>Retry Setup');
                    }
                },
                error: function() {
                    updateStep(2, 'Table Creation Failed', 'Error creating table. Please check your database permissions.', 'error');
                    $('#startSetup').prop('disabled', false).html('<i class="fas fa-redo mr-2"></i>Retry Setup');
                }
            });
        }

        function finishSetup() {
            // Add Step 3
            $('#setupSteps').append(`
                <div class="step success" id="step3">
                    <h5><i class="fas fa-check-circle mr-2"></i>Setup Complete!</h5>
                    <p>The SK Officials database has been set up successfully. You can now manage SK Officials.</p>
                    <a href="../" class="btn btn-success mt-2">
                        <i class="fas fa-users mr-2"></i>Go to SK Officials Management
                    </a>
                </div>
            `);
            
            $('#startSetup').hide();
        }

        function updateStep(stepNum, title, message, status) {
            let icon = '<i class="fas fa-cog fa-spin mr-2"></i>';
            let stepClass = '';
            
            if(status === 'success') {
                icon = '<i class="fas fa-check-circle mr-2"></i>';
                stepClass = 'success';
            } else if(status === 'error') {
                icon = '<i class="fas fa-times-circle mr-2"></i>';
                stepClass = 'error';
            }
            
            $(`#step${stepNum}`).removeClass('step').addClass('step ' + stepClass).html(`
                <h5>${icon}${title}</h5>
                <p>${message}</p>
            `);
        }
    </script>
</body>
</html>
