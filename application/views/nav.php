<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="<?= base_url(); ?>">
        <img src="https://getbootstrap.com/docs/4.6/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <b>SAVE</b>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item <?= $title == 'Dashboard' ? "active" : '' ?>">
                <a class="nav-link" href="<?= base_url(); ?>">Home</a>
            </li>
            <li class="nav-item <?= $title == 'Data Product' ? "active" : '' ?>">
                <a class="nav-link" href="<?= base_url('product'); ?>">Product</a>
            </li>
            <li class="nav-item <?= $title == 'Data Category' ? "active" : '' ?>">
                <a class="nav-link" href="<?= base_url('cat'); ?>">Category</a>
            </li>
            <li class="nav-item <?= $title == 'Data AKL' ? "active" : '' ?>">
                <a class="nav-link" href="<?= base_url('akl'); ?>">AKL</a>
            </li>
        </ul>
    </div>
</nav>