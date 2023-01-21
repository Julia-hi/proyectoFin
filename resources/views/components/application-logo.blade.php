
<?php use Illuminate\Support\Facades\Storage;
$logoUrl = Storage::url('images/logo.png'); ?>
<img src="<?php echo $logoUrl;?>" alt="logo Mi Lorito">