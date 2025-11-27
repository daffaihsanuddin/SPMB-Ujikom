<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi OTP - SPMB Online</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .otp-code { 
            font-size: 32px; 
            font-weight: bold; 
            text-align: center; 
            letter-spacing: 5px;
            color: #007bff;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border: 2px dashed #007bff;
            border-radius: 8px;
        }
        .footer { 
            background: #f1f1f1; 
            padding: 15px; 
            text-align: center; 
            font-size: 12px;
            color: #666;
        }
        .warning { 
            background: #fff3cd; 
            border: 1px solid #ffeaa7; 
            padding: 10px; 
            border-radius: 4px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SPMB Online</h1>
            <p>Sistem Penerimaan Murid Baru</p>
        </div>
        
        <div class="content">
            <h2>Halo, <?php echo e($nama); ?>!</h2>
            <p>Terima kasih telah mendaftar di SPMB Online. Berikut adalah kode OTP untuk verifikasi akun Anda:</p>
            
            <div class="otp-code">
                <?php echo e($otp); ?>

            </div>
            
            <div class="warning">
                <strong>Perhatian:</strong> 
                <ul>
                    <li>Kode OTP berlaku selama <strong><?php echo e($expires_in); ?> menit</strong></li>
                    <li>Jangan berikan kode ini kepada siapapun</li>
                    <li>Jika Anda tidak merasa mendaftar, abaikan email ini</li>
                </ul>
            </div>
            
            <p>Masukkan kode di atas pada halaman verifikasi untuk mengaktifkan akun Anda.</p>
            
            <p>Salam hormat,<br>Tim SPMB Online</p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; <?php echo e(date('Y')); ?> SPMB Online. All rights reserved.</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/emails/verification-otp.blade.php ENDPATH**/ ?>