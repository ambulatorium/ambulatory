<!doctype html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reliqui</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='{{mix('app.css', 'vendor/reliqui')}}' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="reliqui" v-cloak>
        <alert
            :message="alert.message"
            :type="alert.type"
            :auto-close="alert.autoClose"
            :confirmation-proceed="alert.confirmationProceed"
            :confirmation-cancel="alert.confirmationCancel"
            v-if="alert.type">
        </alert>


        <flash
            :message="flash.message"
            :type="flash.type"
            :auto-close="flash.autoClose"
            v-if="flash.type">
        </flash>

        <div class="container mb-5">
            <reliqui-header></reliqui-header>

            <div class="row">
                <div class="col-2 sidebar">
                    <reliqui-sidebar></reliqui-sidebar>
                </div>

                <div class="col-10">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Reliqui Object -->
    <script>
        window.Reliqui = @json($reliquiScriptVariables);
    </script>

    <script src="{{mix('app.js', 'vendor/reliqui')}}"></script>
</body>
</html>