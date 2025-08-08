<!DOCTYPE html>
<html lang="en">
@include('layout.head')



<body>
    <!-- Overlay for mobile -->
    @include('layout.sidebar')

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        @include('layout.header')

        <!-- Content -->
        <div class="content">
            @yield('content')

        </div>
    </div>

    @include('layout.script')
    @include('layout.footer')

</body>

</html>