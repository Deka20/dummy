<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.3/dist/full.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="card-title text-2xl font-bold">Thankyou!</h2>
                    <p class="text-sm text-gray-500">{{ date('d M Y, H:i') }}</p>
                </div>
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-16">
                        <span class="text-2xl">MS</span>
                    </div>
                </div>
            </div>

            <div class="divider my-2"></div>

            <div class="space-y-4">
                <h1>Thankyou for your purchases.</h1>
            </div>

            <div class="divider my-2"></div>

            <div class="p-4 bg-base-200 rounded-lg">
                <h3 class="font-semibold mb-2">Ketentuan:</h3>
                <ul class="text-sm space-y-1">
                    <li>• Harap datang 15 menit sebelum waktu reservasi</li>
                    <li>• Pembatalan dapat dilakukan maksimal 24 jam sebelumnya</li>
                    <li>• Keterlambatan lebih dari 30 menit akan mengurangi waktu sesi</li>
                    <li>• Pembayaran dilakukan di tempat saat kedatangan</li>
                </ul>
            </div>

            <div class="card-actions justify-center mt-6">
                <a href="/index">
                    <button class="btn btn-primary btn-block gap-2">
                        Back to Home
                    </button>
                </a>
            </div>

            <div class="text-center text-sm text-gray-500 mt-4">
                <p>Terima kasih telah melakukan pemesanan studio!</p>
                <p>Butuh bantuan? Hubungi kami di: +62 882 7115 9334</p>
            </div>
        </div>
    </div>
</body>
</html>