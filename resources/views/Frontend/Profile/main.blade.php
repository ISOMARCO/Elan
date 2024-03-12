<!doctype html>
<html lang="en">
<head>
    @include('Frontend.Sections.head')
</head>
<body>
    @include('Frontend.Sections.header')
    <section class="single-banner dashboard-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-content">
                        <h2>profile</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('Frontend.Home')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('Frontend.Sections.footer')
</body>
</html>
