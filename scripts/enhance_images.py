from pathlib import Path
from PIL import Image, ImageEnhance, ImageOps


def enhance_image(im: Image.Image) -> Image.Image:
    # Ensure RGB
    im = im.convert("RGB")
    # Automatic contrast (removes extreme pixels)
    im = ImageOps.autocontrast(im, cutoff=1)
    # Gentle color boost
    im = ImageEnhance.Color(im).enhance(1.15)
    # Slight contrast and brightness increase
    im = ImageEnhance.Contrast(im).enhance(1.08)
    im = ImageEnhance.Brightness(im).enhance(1.03)
    # Light sharpening
    im = ImageEnhance.Sharpness(im).enhance(1.25)
    return im


def process_folder(input_dir: Path, output_dir: Path):
    output_dir.mkdir(parents=True, exist_ok=True)
    supported = (".jpg", ".jpeg", ".png", ".webp", ".tif", ".tiff")
    files = [p for p in input_dir.iterdir() if p.suffix.lower() in supported]
    if not files:
        print(f"Nenhuma imagem encontrada em {input_dir.resolve()}")
        return

    for p in files:
        try:
            with Image.open(p) as im:
                enhanced = enhance_image(im)
                out_name = p.stem + "_enhanced" + ".jpg"
                out_path = output_dir / out_name
                enhanced.save(out_path, format="JPEG", quality=90)
                print(f"Salvo: {out_path}")
        except Exception as e:
            print(f"Erro processando {p.name}: {e}")


if __name__ == "__main__":
    in_dir = Path("assets/images/input")
    out_dir = Path("assets/images/output")
    if not in_dir.exists():
        print(f"Pasta de entrada não existe: {in_dir.resolve()}")
        print("Crie a pasta e coloque as imagens que quer melhorar em assets/images/input/")
    else:
        process_folder(in_dir, out_dir)
