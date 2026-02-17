<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0; background:#f4f6f9;">
        <tr>
            <td align="center">

                <img src="https://via.placeholder.com/120"
                     width="120"
                     style="display:block; margin:0 auto 15px auto;">

                <table width="500" cellpadding="0" cellspacing="0"
                       style="max-width:500px; width:100%; background:#ffffff; border-radius:12px; overflow:hidden;">

                    <tr>
                        <td style="background:#173161; padding:20px; text-align:center;">
                            <h2 style="color:#ffffff; margin:0;">Reset Password Presto!</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px; text-align:center; color:#333;">

                            <p style="font-size:16px; margin-bottom:20px;">
                                Hai richiesto il reset della password.
                            </p>

                            <a href="{{ $url }}"
                               style="display:inline-block;
                                      background:#173161;
                                      color:#ffffff;
                                      padding:12px 25px;
                                      text-decoration:none;
                                      border-radius:8px;
                                      font-weight:bold;">
                                Reset Password
                            </a>

                            <p style="font-size:14px; color:#666; margin-top:20px;">
                                Questo link scadrà tra 60 minuti.
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 30px;">
                            <hr style="border:none; border-top:1px solid #eee;">
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 30px; text-align:center;">

                            <p style="font-size:13px; color:#888;">
                                Se non riesci a cliccare il bottone, copia e incolla questo link:
                            </p>

                            <p style="word-break:break-all; font-size:13px;">
                                <a href="{{ $url }}" style="color:#173161;">
                                    {{ $url }}
                                </a>
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px; text-align:center; font-size:12px; color:#999;">
                            Se non hai richiesto il reset, ignora questa email.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>