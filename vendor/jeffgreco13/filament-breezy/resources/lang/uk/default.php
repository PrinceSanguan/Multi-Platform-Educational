<?php

return [
    'login' => [
        'username_or_email' => "Ім'я користувача або електронна пошта",
        'forgot_password_link' => 'Забули пароль?',
        'create_an_account' => 'Створити акаунт',
    ],
    'password_confirm' => [
        'heading' => 'Підтвердити пароль',
        'description' => 'Будь ласка, підтвердіть свій пароль для завершення цієї дії.',
        'current_password' => 'Поточний пароль',
    ],
    'two_factor' => [
        'heading' => 'Двофакторна аутентифікація',
        'description' => 'Будь ласка, підтвердіть доступ, ввівши пароль із додатка',
        'code_placeholder' => 'XXX-XXX',
        'recovery' => [
            'heading' => 'Двофакторна аутентифікація',
            'description' => 'Будь ласка, підтвердьте доступ до вашого облікового запису, ввівши один із ваших аварійних кодів відновлення.',
        ],
        'recovery_code_placeholder' => 'abcdef-98765',
        'recovery_code_text' => 'Втратили пристрій?',
        'recovery_code_link' => 'Використати код відновлення',
        'back_to_login_link' => 'Повернутися до входу',
    ],
    'profile' => [
        'account' => 'Обліковий запис',
        'profile' => 'Профіль',
        'my_profile' => 'Мій профіль',
        'subheading' => 'Керуйте своїм профілем користувача тут.',
        'personal_info' => [
            'heading' => 'Особиста інформація',
            'subheading' => 'Керуйте своєю особистою інформацією.',
            'submit' => [
                'label' => 'Оновити',
            ],
            'notify' => 'Профіль успішно оновлено!',
        ],
        'password' => [
            'heading' => 'Пароль',
            'subheading' => 'Мінімум 8 символів.',
            'submit' => [
                'label' => 'Оновити',
            ],
            'notify' => 'Пароль успішно оновлено!',
        ],
        '2fa' => [
            'title' => 'Двофакторна аутентифікація',
            'description' => 'Керуйте двофакторною аутентифікацією для вашого облікового запису (рекомендується).',
            'actions' => [
                'enable' => 'Увімкнути',
                'regenerate_codes' => 'Згенерувати коди відновлення',
                'disable' => 'Вимкнути',
                'confirm_finish' => 'Підтвердити і завершити',
                'cancel_setup' => 'Скасувати налаштування',
            ],
            'setup_key' => 'Ключ налаштування',
            'must_enable' => 'Ви повинні увімкнути двофакторну аутентифікацію, щоб використовувати цю програму.',
            'not_enabled' => [
                'title' => 'Ви не увімкнули двофакторну аутентифікацію.',
                'description' => 'Коли двофакторна аутентифікація увімкнена, вам буде запропоновано ввести безпечний, випадковий токен під час аутентифікації. Ви можете отримати цей токен з програми Google Authenticator на вашому телефоні.',
            ],
            'finish_enabling' => [
                'title' => 'Завершити увімкнення двофакторної аутентифікації.',
                'description' => 'Щоб завершити увімкнення двофакторної аутентифікації, скануйте наступний QR-код за допомогою програми-аутентифікатора на вашому телефоні або введіть ключ налаштування та надайте згенерований OTP код.',
            ],
            'enabled' => [
                'notify' => 'Двофакторна аутентифікація увімкнена.',
                'title' => 'Ви увімкнули двофакторну аутентифікацію!',
                'description' => 'Двофакторна аутентифікація тепер увімкнена. Це допоможе зробити ваш обліковий запис більш захищеним.',
                'store_codes' => 'Ці коди можна використовувати для відновлення доступу до вашого облікового запису, якщо ваш пристрій буде втрачено. Увага! Ці коди будуть показані лише один раз.',
            ],
            'disabling' => [
                'notify' => 'Двофакторну аутентифікацію вимкнено.',
            ],
            'regenerate_codes' => [
                'notify' => 'Нові коди відновлення згенеровані.',
            ],
            'confirmation' => [
                'success_notification' => 'Код підтверджено. Двофакторна аутентифікація увімкнена.',
                'invalid_code' => 'Введений вами код недійсний.',
            ],
        ],
        'sanctum' => [
            'title' => 'API Токени',
            'description' => 'Керуйте токенами API, які дозволяють стороннім службам отримувати доступ до цього додатка від вашого імені.',
            'create' => [
                'notify' => 'Токен успішно створено!',
                'message' => 'Ваш токен відображається лише один раз при створенні. Якщо ви втратите свій токен, вам потрібно буде видалити його і створити новий.',
                'submit' => [
                    'label' => 'Створити',
                ],
            ],
            'update' => [
                'notify' => 'Токен успішно оновлено!',
            ],
            'copied' => [
                'label' => 'Я скопіював свій токен',
            ],
        ],
    ],
    'clipboard' => [
        'link' => 'Копіювати в буфер обміну',
        'tooltip' => 'Скопійовано!',
    ],
    'fields' => [
        'avatar' => 'Аватар',
        'email' => 'E-mail',
        'login' => 'Логін',
        'name' => 'Ім\'я',
        'password' => 'Пароль',
        'password_confirm' => 'Підтвердження пароля',
        'new_password' => 'Новий пароль',
        'new_password_confirmation' => 'Підтвердження пароля',
        'token_name' => 'Назва токена',
        'token_expiry' => 'Термін дії токена',
        'abilities' => 'Доступ',
        '2fa_code' => 'Код',
        '2fa_recovery_code' => 'Код відновлення',
        'created' => 'Створено',
        'expires' => 'Закінчується',
    ],
    'or' => 'Або',
    'cancel' => 'Скасувати',
];
