<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>إنشاء صورة باستخدام JavaScript</title>
</head>

<body>
    <canvas id="canvas" width="1199" height="630" style="border:1px solid #d3d3d3;"></canvas>
    <br>
    <button onclick="downloadImage()">Download Image</button>

    <script>
        function drawTextOnImage() {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');

            const backgroundImage = new Image();
            backgroundImage.src = "1rm120batch2-techi-14-framebg.jpg";
            backgroundImage.onload = () => {

                canvas.width = backgroundImage.width;
                canvas.height = backgroundImage.height;

                context.drawImage(backgroundImage, 0, 0);

                const text = '"فَمَدَّ الْمَلِكُ لأَسْتِيرَ قَضِيبَ الذَّهَبِ، فَقَامَتْ أَسْتِيرُ وَوَقَفَتْ أَمَامَ الْمَلِكِ" (أس 8: 4).';
                context.font = '50px Arial';
                context.fillStyle = 'black';
                context.textAlign = 'center';

                const lines = wrapText(context, text, canvas.width - 100);

                const lineHeight = 70;
                const startY = canvas.height / 2 - (lines.length / 2) * lineHeight;

                lines.forEach((line, i) => {
                    context.fillText(line, canvas.width / 2, startY + i * lineHeight);
                });
            };
        }

        function wrapText(context, text, maxWidth) {
            const words = text.split(' ');
            let line = '';
            const lines = [];

            words.forEach(word => {
                const testLine = line + word + ' ';
                const metrics = context.measureText(testLine);
                const testWidth = metrics.width;
                if (testWidth > maxWidth && line.length > 0) {
                    lines.push(line);
                    line = word + ' ';
                } else {
                    line = testLine;
                }
            });
            lines.push(line);
            return lines;
        }

        function downloadImage() {
            const canvas = document.getElementById('canvas');
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/jpeg');
            link.download = 'output.jpg';
            link.click();
        }

        window.onload = drawTextOnImage;
    </script>
</body>

</html>