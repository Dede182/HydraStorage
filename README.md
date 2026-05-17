# Hydra Storage

Laravel package for fast image uploads with optional compression, resizing, and WebP optimization.

## Requirements

- PHP 8.1+
- Laravel 10 or 11
- **GD** (built into most PHP installs) or **Imagick** (optional, recommended when available)

Imagick is **not required**. When it is not installed, the package uses the GD driver automatically.

## Installation

```bash
composer require dede/hydrastorage
```

Publish the config:

```bash
php artisan vendor:publish --tag="hydrastorage-config"
```

Add the `HydraMedia` trait to your model or controller:

```php
use HydraStorage\HydraStorage\Traits\HydraMedia;

class YourController extends Controller
{
    use HydraMedia;
}
```

## Configuration

After publishing, edit `config/hydrastorage.php` or set these in `.env`:

```env
STORAGE_PROVIDER=local
COMPRESSED_QUALITY=60

# auto | imagick | gd — "auto" prefers Imagick when loaded, otherwise GD
HYDRA_IMAGE_DRIVER=auto

# When true, compressed uploads are saved as .webp for smaller file size
HYDRA_SAVE_AS_WEBP=false
```

| Key | Env | Default | Description |
|-----|-----|---------|-------------|
| `provider` | `STORAGE_PROVIDER` | `local` | Laravel storage disk name |
| `compressed_quality` | `COMPRESSED_QUALITY` | `60` | WebP/JPEG quality (1–100) |
| `image_driver` | `HYDRA_IMAGE_DRIVER` | `auto` | Image backend: `auto`, `imagick`, or `gd` |
| `save_as_webp` | `HYDRA_SAVE_AS_WEBP` | `false` | Save compressed uploads as `.webp` |
| `webp_quality` | `HYDRA_WEBP_QUALITY` | `compressed_quality` | WebP quality (1–100); lower = smaller files |
| `webp_strip_metadata` | `HYDRA_WEBP_STRIP_METADATA` | `true` | Strip EXIF/metadata from WebP output |
| `public_prefix` | — | `false` | Prefix public disk paths when resolving URLs |

## Usage

### Basic upload

```php
use HydraStorage\HydraStorage\Service\Option\MediaOption;

// Store without compression (original format)
$filename = $this->storeMedia($request->file('photo'), 'uploads');

// Store with compression/manipulation pipeline
$filename = $this->storeMedia($request->file('photo'), 'uploads', compression: true);
```

### Media options

Build options with the fluent `MediaOption` API:

```php
use HydraStorage\HydraStorage\Service\Option\MediaOption;

$option = (new MediaOption())
    ->resize('medium')           // thumbnail | small | medium | large | custom
    ->setQuality(60)             // compress to WebP at given quality
    ->grayscale()
    ->setWaterMark($watermarkPath, position: 'center', opacity: 80)
    ->setPrefixFileName('avatar')
    ->webp();                     // override config: force .webp output

$filename = $this->storeMedia($request->file('photo'), 'uploads', compression: true, mediaOption: $option);
```

Custom resize dimensions:

```php
$option = (new MediaOption())->resize('custom', width: 300, height: 200);
```

### Save as WebP

WebP reduces storage size. Enable it globally or per upload.

**Globally** (`.env` or config):

```env
HYDRA_SAVE_AS_WEBP=true
```

```php
// Uses config — compressed files are stored as .webp
$filename = $this->storeMedia($request->file('photo'), 'uploads', compression: true);
```

**Per upload** (overrides config):

```php
$option = (new MediaOption())->webp();

$filename = $this->storeMedia($request->file('photo'), 'uploads', compression: true, mediaOption: $option);
```

Disable WebP for a single upload when config is enabled:

```php
$option = (new MediaOption())->webp(false);
```

`setQuality()` always encodes to WebP at the given quality, regardless of `save_as_webp`.

### Lightweight storage (smallest files)

For the best size reduction on real JPEG/PNG uploads:

```env
HYDRA_SAVE_AS_WEBP=true
HYDRA_WEBP_QUALITY=55
HYDRA_WEBP_STRIP_METADATA=true
```

**Per upload** — WebP only (keeps full dimensions, ~30–55% smaller on photos):

```php
$option = (new MediaOption())->webp();
// or force WebP + quality in one call:
$option = (new MediaOption())->lightweight(55);
```

**Maximum savings** — resize + WebP (recommended for galleries/avatars):

```php
$option = (new MediaOption())
    ->resize('medium')   // 600×600 — biggest size win
    ->lightweight(55);

$filename = $this->storeMedia($request->file('photo'), 'uploads', compression: true, mediaOption: $option);
```

| Approach | Typical result |
|----------|----------------|
| `webp()` only | Same dimensions, smaller format (e.g. 1.3 MB → ~600 KB) |
| `lightweight(55)` | WebP at quality 55, metadata stripped |
| `resize('medium')` + `lightweight()` | Smallest files (e.g. 1.3 MB → ~50–150 KB) |

Lower `HYDRA_WEBP_QUALITY` (40–55) = smaller files, slightly softer image. Start at `55` and adjust.

### Batch uploads

```php
$filenames = $this->storeMedia($request->file('photos'), 'uploads', compression: true, mediaOption: $option);
```

### Other helpers

```php
// Get public URL
$url = $this->getMedia($filename, folder: 'uploads');

// Delete a file
$this->removeMedia('uploads/'.$filename);

// Delete a folder
$this->dropDirectory('uploads');
```

## Image driver

| Value | Behavior |
|-------|----------|
| `auto` | Imagick if the PHP extension is loaded, otherwise GD |
| `imagick` | Use Imagick (falls back to GD if unavailable) |
| `gd` | Use GD only |

WebP output requires WebP support in the active driver (`imagewebp` for GD, or Imagick).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Htet-Shine-Htwe](https://github.com/Dede182)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
