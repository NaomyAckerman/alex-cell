<?php

return [
    // Exceptions
    'invalidModel'              => 'The {0} model must be loaded prior to use.',
    'userNotFound'              => 'Unable to locate a user with ID = {0, number}.',
    'noUserEntity'              => 'User Entity must be provided for password validation.',
    'tooManyCredentials'        => 'You may only validate against 1 credential other than a password.',
    'invalidFields'             => 'The "{0}" field cannot be used to validate credentials.',
    'unsetPasswordLength'       => 'You must set the `minimumPasswordLength` setting in the Auth config file.',
    'unknownError'              => 'Sorry, we encountered an issue sending the email to you. Please try again later.',
    'notLoggedIn'               => 'You must be logged in to access that page.',
    'notEnoughPrivilege'        => 'You do not have sufficient permissions to access that page.',

    // Registration
    'registerDisabled'          => 'Sorry, new user accounts are not allowed at this time.',
    'registerSuccess'           => 'Welcome aboard! Please login with your new credentials.',
    'registerCLI'               => 'New user created: {0}, #{1}',

    // Activation
    'activationNoUser'          => 'Tidak dapat menemukan pengguna dengan kode aktivasi tersebut.',
    'activationSubject'         => 'Aktivasi akun anda',
    'activationSuccess'         => 'Silakan konfirmasi akun Anda dengan mengklik link aktivasi di email yang kami kirimkan.',
    'activationResend'          => 'Kirim ulang pesan aktivasi sekali lagi.',
    'notActivated'              => 'Akun pengguna ini belum diaktifkan.',
    'errorSendingActivation'    => 'Gagal mengirim pesan aktivasi ke: {0}',

    // Login
    'badAttempt'                => 'Anda tidak dapat login. Harap periksa kredensial Anda.',
    'loginSuccess'              => 'Welcome back!',
    'invalidPassword'           => 'Anda tidak dapat login. Harap periksa sandi Anda.',

    // Forgotten Passwords
    'forgotDisabled'            => 'Opsi pengaturan ulang kata sandi telah dinonaktifkan.',
    'forgotNoUser'              => 'Tidak dapat menemukan pengguna dengan email itu.',
    'forgotSubject'             => 'Instruksi Reset Kata Sandi',
    'resetSuccess'              => 'Kata sandi Anda berhasil diubah. Silakan login dengan kata sandi baru.',
    'forgotEmailSent'           => 'Token keamanan telah dikirimkan ke email Anda. Masukkan ke dalam kotak di bawah untuk melanjutkan.',
    'errorEmailSent'            => 'Tidak dapat mengirim email dengan instruksi pengaturan ulang kata sandi ke: {0}',

    // Passwords
    'errorPasswordLength'       => 'Kata sandi setidaknya harus {0, number} karakter.',
    'suggestPasswordLength'     => 'Lewati frasa - hingga 255 karakter - buat kata sandi yang lebih aman dan mudah diingat.',
    'errorPasswordCommon'       => 'Kata sandi tidak boleh menjadi kata sandi yang umum.',
    'suggestPasswordCommon'     => 'The password was checked against over 65k commonly used passwords or passwords that have been leaked through hacks.',
    'errorPasswordPersonal'     => 'Passwords cannot contain re-hashed personal information.',
    'suggestPasswordPersonal'   => 'Variations on your email address or username should not be used for passwords.',
    'errorPasswordTooSimilar'    => 'Password is too similar to the username.',
    'suggestPasswordTooSimilar'  => 'Do not use parts of your username in your password.',
    'errorPasswordPwned'        => 'The password {0} has been exposed due to a data breach and has been seen {1, number} times in {2} of compromised passwords.',
    'suggestPasswordPwned'      => '{0} should never be used as a password. If you are using it anywhere change it immediately.',
    'errorPasswordEmpty'        => 'A Password is required.',
    'passwordChangeSuccess'     => 'Password changed successfully',
    'userDoesNotExist'          => 'Password was not changed. User does not exist',
    'resetTokenExpired'         => 'Sorry. Your reset token has expired.',

    // Groups
    'groupNotFound'             => 'Unable to locate group: {0}.',

    // Permissions
    'permissionNotFound'        => 'Unable to locate permission: {0}',

    // Banned
    'userIsBanned'              => 'User has been banned. Contact the administrator',

    // Too many requests
    'tooManyRequests'           => 'Too many requests. Please wait {0, number} seconds.',

    // Login views
    'home'                      => 'Home',
    'current'                   => 'Current',
    'forgotPassword'            => 'Lupa password Anda?',
    'enterEmailForInstructions' => 'Tidak masalah! Masukkan email Anda di bawah ini dan kami akan mengirimkan instruksi untuk mengatur ulang password Anda.',
    'email'                     => 'Email',
    'emailAddress'              => 'Alamat Email',
    'sendInstructions'          => 'Send Instructions',
    'loginTitle'                => 'Login',
    'loginAction'               => 'Login',
    'rememberMe'                => 'Ingat saya',
    'needAnAccount'             => 'Need an account?',
    'forgotYourPassword'        => 'lupa password Anda?',
    'password'                  => 'Password',
    'repeatPassword'            => 'Repeat Password',
    'emailOrUsername'           => 'Email / username',
    'username'                  => 'Username',
    'register'                  => 'Register',
    'signIn'                    => 'Sign In',
    'alreadyRegistered'         => 'Already registered?',
    'weNeverShare'              => 'We\'ll never share your email with anyone else.',
    'resetYourPassword'         => 'Reset password Anda',
    'enterCodeEmailPassword'    => 'Masukkan kode yang Anda terima melalui email, alamat email Anda, dan kata sandi baru Anda.',
    'token'                     => 'Token',
    'newPassword'               => 'New Password',
    'newPasswordRepeat'         => 'Repeat New Password',
    'resetPassword'             => 'Reset Password',
];
