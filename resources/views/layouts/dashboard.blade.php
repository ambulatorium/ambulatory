<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Meta Information --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href='{{ mix('app.css', 'vendor/ambulatory') }}' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="ambulatory" v-cloak>
        <alert v-if="alert.type"
            :message="alert.message" :mode="alert.mode" :type="alert.type"
            :auto-close="alert.autoClose" :confirmation-proceed="alert.confirmationProceed"
            :confirmation-cancel="alert.confirmationCancel">
        </alert>

        <booking v-if="booking.schedule" :schedule="booking.schedule"></booking>

        <div class="container">
            <div class="row">
                <div class="col-3 sidebar">
                    <sidebar-menu></sidebar-menu>
                </div>

                <div class="col-9 bg-white p-0">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>

    {{-- Global Ambulatory Object --}}
    <script>
        window.Ambulatory = @json($ambulatoryScriptVariables);
    </script>

    <script src="{{ mix('app.js', 'vendor/ambulatory') }}"></script>
</body>
</html>