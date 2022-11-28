<div class="container">
    <h1><?= $title ?></h1>

    <form method="POST" action="<?= base_url('bunga/edit/' . $bunga->id) ?>">
        <div class="form-group">
            <label for="nama">Nama Bunga</label>
            <input name="nama" type="text" class="form-control" id="nama" placeholder="Masukkan Nama Bunga" value="<?= $bunga->nama; ?>" autofocus required>
            <small class="text-danger">
                <?php echo form_error('nama') ?>
            </small>
        </div>
        <div class="form-group">
            <label for="warna">Warna Bunga</label>
            <input name="warna" type="text" class="form-control" id="warna" placeholder="Masukkan Warna Bunga" value="<?= $bunga->warna; ?>" required>
            <small class="text-danger">
                <?php echo form_error('warna') ?>
            </small>
        </div>
        <div class="form-group">
            <label for="asal">Asal Bunga</label>
            <input name="asal" type="text" class="form-control" id="asal" placeholder="Masukkan Asal Bunga" value="<?= $bunga->asal; ?>" required>
            <small class="text-danger">
                <?php echo form_error('asal') ?>
            </small>
        </div>
        <a href="<?= base_url('bunga') ?>" class="btn btn-secondary mt-2 mb-2">Kembali</a>
        <button type="reset" class="btn btn-warning">Reset</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>