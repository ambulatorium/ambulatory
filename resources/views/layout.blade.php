<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reliqui ambulatory</title>

    <!-- Style sheets-->
    <link href='{{ mix('app.css', 'vendor/ambulatory') }}' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="ambulatory" v-cloak>
    <alert :message="alert.message"
        :type="alert.type"
        :auto-close="alert.autoClose"
        :confirmation-proceed="alert.confirmationProceed"
        :confirmation-cancel="alert.confirmationCancel"
        v-if="alert.type"></alert>

    <flash :message="flash.message"
        :type="flash.type"
        :auto-close="flash.autoClose"
        v-if="flash.type"></flash>

    <div class="container">
        <div class="row">
            <div class="col-3 sidebar">
                <sidebar-menu></sidebar-menu>
            </div>

            <div class="col-9 bg-white border p-0">
                <router-view></router-view>
            </div>
        </div>
    </div>
</div>

<!-- Global Ambulatory Object -->
<script>
    window.Ambulatory = @json($ambulatoryScriptVariables);
</script>

<script src="{{ mix('app.js', 'vendor/ambulatory') }}"></script>
</body>
</html>