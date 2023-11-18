const imagenDiv = document.getElementById('imagenDiv');
    const BongoClap = document.getElementById('BongoClap');
    let isClapImage = true;

    imagenDiv.addEventListener('click', () => {
        if (isClapImage) {
            BongoClap.src = 'Frames\\UP.webp';
            BongoClap.alt = 'UP';
        } else {
            BongoClap.src = 'Frames\\CLAP.webp';
            BongoClap.alt = 'CLAP';
        }
        isClapImage = !isClapImage;
    });

    clickCount++;