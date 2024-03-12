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
                        <h2>ad post</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ad-post</li>
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
                            <div class="dash-avatar">
                                <a href="#">
                                    <img src="images/avatar/01.jpg" alt="avatar">
                                </a>
                            </div>
                            <div class="dash-intro">
                                <h4>
                                    <a href="#">gackon Honson</a>
                                </h4>
                                <h5>new seller</h5>
                                <ul class="dash-meta">
                                    <li>
                                        <i class="fas fa-phone-alt"></i>
                                        <span>(123) 000-1234</span>
                                    </li>
                                    <li>
                                        <i class="fas fa-envelope"></i>
                                        <span>gackon@gmail.com</span>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Los Angeles, West America</span>
                                    </li>
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
                            <p>From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and Edit your password and account details.</p>
                            <button data-dismiss="alert">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="dash-menu-list">
                            <ul>
                                <li>
                                    <a href="dashboard.html">dashboard</a>
                                </li>
                                <li>
                                    <a href="profile.html">Profile</a>
                                </li>
                                <li>
                                    <a class="active" href="ad-post.html">ad post</a>
                                </li>
                                <li>
                                    <a href="my-ads.html">my ads</a>
                                </li>
                                <li>
                                    <a href="setting.html">settings</a>
                                </li>
                                <li>
                                    <a href="bookmark.html">bookmarks</a>
                                </li>
                                <li>
                                    <a href="message.html">message</a>
                                </li>
                                <li>
                                    <a href="notification.html">notification</a>
                                </li>
                                <li>
                                    <a href="user-form.html">logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="adpost-part">
        <div class="container">
            <form class="adpost-form">
                <div class="adpost-card">
                    <div class="adpost-title">
                        <h3>Ad Information</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Product Title</label>
                                <input type="text" class="form-control" placeholder="Type your product title here">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">product image</label>
                                <input type="file" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Product Category</label>
                                <select class="form-control custom-select">
                                    <option selected>Select Category</option>
                                    <option value="1">property</option>
                                    <option value="2">electronics</option>
                                    <option value="3">automobiles</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" placeholder="Enter your pricing amount">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">ad description</label>
                                <textarea class="form-control" placeholder="Describe your message"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">ad tag</label>
                                <textarea class="form-control" placeholder="Maximum of 15 keywords"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="adpost-card">
                    <div class="adpost-title">
                        <h3>Author Information</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="Your Name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Number</label>
                                <input type="number" class="form-control" placeholder="Your Number">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Your Address">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-inline">
                        <i class="fas fa-check-circle"></i>
                        <span>Publish your ad</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
    @include('Frontend.Sections.footer')
</body>
</html>
