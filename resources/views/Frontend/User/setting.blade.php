<!DOCTYPE html>
<html lang="en">
<head>
    @include('Frontend.Sections.head')
    <link rel="stylesheet" href="css/custom/setting.css">
</head>
<body>
@include('Frontend.Sections.header')
<section class="single-banner dashboard-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="single-content">
                    <h2>setting</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">setting</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="dash-header-part">
    <div class="container">
        <div class="dash-header-card">
            <div class="row">
                <div class="col-lg-5">
                    <div class="dash-header-left">
                        <div class="dash-avatar"><a href="javascript:void(0)"><img src="{{asset('Assets/Frontend/images/avatar/01.jpg')}}" alt="avatar"></a></div>
                        <div class="dash-intro">
                            <h4><a href="#">gackon Honson</a></h4>
                            <h5>new seller</h5>
                            <ul class="dash-meta">
                                <li><i class="fas fa-phone-alt"></i><span>(123) 000-1234</span></li>
                                <li><i class="fas fa-envelope"></i><span>gackon@gmail.com</span></li>
                                <li><i class="fas fa-map-marker-alt"></i><span>Los Angeles, West America</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="dash-header-right">
                        <div class="dash-focus dash-list">
                            <h2>2433</h2>
                            <p>listing ads</p>
                        </div>
                        <div class="dash-focus dash-book">
                            <h2>2433</h2>
                            <p>total follower</p>
                        </div>
                        <div class="dash-focus dash-rev">
                            <h2>2433</h2>
                            <p>total review</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="dash-header-alert alert fade show">
                        <p>From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and Edit your password and account details.</p><button data-dismiss="alert"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="dash-menu-list">
                        <ul>
                            <li><a href="dashboard.html">dashboard</a></li>
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="ad-post.html">ad post</a></li>
                            <li><a href="my-ads.html">my ads</a></li>
                            <li><a class="active" href="setting.html">settings</a></li>
                            <li><a href="bookmark.html">bookmarks</a></li>
                            <li><a href="message.html">message</a></li>
                            <li><a href="notification.html">notification</a></li>
                            <li><a href="user-form.html">logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="setting-part">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="account-card alert fade show">
                    <div class="account-title">
                        <h3>Edit Profile</h3><button data-dismiss="alert">close</button>
                    </div>
                    <form class="setting-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">First Name</label><input type="text" class="form-control" placeholder="Mahmudul"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Last Name</label><input type="text" class="form-control" placeholder="Hasan"></div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group"><label class="form-label">Company</label><input type="text" class="form-control" placeholder="Classicads Advertising LID."></div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group"><label class="form-label">Address</label><input type="text" class="form-control" placeholder="1420, West Jalkuri, Narayanganj, Bangladesh"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">City</label><input type="text" class="form-control" placeholder="Narayanganj"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">State</label><input type="text" class="form-control" placeholder="West Jalkuri"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Post Code</label><input type="text" class="form-control" placeholder="1420"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Country</label><input type="text" class="form-control" placeholder="Bangladesh"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Website</label><input type="text" class="form-control" placeholder="https://mironmahmud.com"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Phone</label><input type="text" class="form-control" placeholder="+8801838288389"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Birthday</label><input type="date" class="form-control" value="1995-02-02"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"><label class="form-label">Profile Image</label><input type="file" class="form-control"></div>
                            </div>
                            <div class="col-lg-12"><button class="btn btn-inline"><i class="fas fa-user-check"></i><span>update profile</span></button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Frontend.Sections.footer')
</body>
</html>
