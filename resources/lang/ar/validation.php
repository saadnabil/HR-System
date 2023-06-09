<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */
    'user_id.exists' => 'غير مسموح لك .',
    'accepted' => 'يجب قبول :attribute.',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا.',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف.',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute سوى على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط.',
    'array' => 'يجب أن يكون :attribute ًمصفوفة.',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date.',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max.',
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max.',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false .',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals' => 'يجب أن يكون :attribute مطابقاً للتاريخ :date.',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفين.',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام.',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام .',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية.',
    'ends_with' => 'يجب أن ينتهي :attribute بأحد القيم التالية: :values',
    'exists' => 'القيمة المحددة :attribute غير موجودة.',
    'file' => 'الـ :attribute يجب أن يكون ملفا.',
    'filled' => ':attribute إجباري.',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النّص :attribute أكثر من :value حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :value حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :value عُنصرًا/عناصر.',
    ],
    'image' => 'يجب أن يكون الملف صورةً.',
    'in' => ':attribute غير موجود.',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيحًا.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json' => 'يجب أن يكون :attribute نصًا من نوع JSON.',
    'lt' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أصغر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أصغر من :value كيلوبايت.',
        'string' => 'يجب أن يكون طول النّص :attribute أقل من :value حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على أقل من :value عناصر/عنصر.',
    ],
    'lte' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :value.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :value كيلوبايت.',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :value حروفٍ/حرفًا.',
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'max' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :max.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت.',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا.',
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر.',
    ],
    'multiple_of' => ':attribute يجب أن يكون من مضاعفات :value',
    'not_in' => 'العنصر :attribute غير صحيح.',
    'not_regex' => 'صيغة :attribute غير صحيحة.',
    'numeric' => 'يجب على :attribute أن يكون رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب تقديم :attribute.',
    'regex' => 'صيغة :attribute .غير صحيحة.',
    'required' => 'هذا الحقل  مطلوب.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
    'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size.',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالضبط.',
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالضبط.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا.',
    'unique' => 'قيمة :attribute مُستخدمة من قبل.',
    'uploaded' => 'فشل في تحميل الـ :attribute.',
    'url' => 'صيغة الرابط :attribute غير صحيحة.',
    'uuid' => ':attribute يجب أن يكون بصيغة UUID سليمة.',
    'failed' => 'البيانات المدخلة غير صحيحة.',
    'unacceped_dates' => 'هذة المواعيد مشغوله لديك . من فضلك اختر موعد اخر',
    'not allowed' => 'غير مسموح لك .',
    'property_image' => 'تأكد من الصور المرفوعة',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */

    'attributes' => [
        'name' => 'الاسم',
        'name_ar' => 'الاسم عربي',
        'name_en' => 'الاسم انجليزي',
        'username' => 'اسم المُستخدم',
        'email' => 'البريد الالكتروني',
        'password' => 'كلمة المرور',
        'old_password' => 'كلمة المرور القديمة',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'address_ar'=>'العنوان عربي',
        'address_en'=>'العنوان انجليزي',
        'phone' => 'رقم الجوال',
        'age' => 'العمر',
        'sex' => 'الجنس',
        'gender' => 'النوع',
        'day' => 'اليوم',
        'month' => 'الشهر',
        'year' => 'السنة',
        'hour' => 'ساعة',
        'minute' => 'دقيقة',
        'second' => 'ثانية',
        'title' => 'العنوان',
        'content' => 'المُحتوى',
        'description' => 'الوصف',
        'description_ar' => 'الوصف عربي',
        'description_en' => 'الوصف انجليزي',
        'excerpt' => 'المُلخص',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'مُتاح',
        'size' => 'الحجم',
        'code' => ' الكود',
        'image' => 'الصورة',
        'terms_ar'=>'الشروط والاحكام عربي',
        'terms_en'=>'الشروط والاحكام انجليزي',
        'policy_ar'=>'سياسة الخصوصية عربي',
        'policy_en'=>'سياسة الخصوصية انجليزي',
        'tax'=>'الضريبة',
        'type'=>'النوع',
        'user_id'=>'اسم المستخدم',
        'code'=>'الكود',
        'start_date'=>'تاريخ البدء',
        'end_date'=>'تاريخ الانتهاء',
        'price'=>'السعر',
        'status'=>'الحالة',
        'lat'=>'الموقع',
        'lng'=>'الموقع',
        'logo'=>'الشعار',
        'title'=>'العنوان',
        'message'=>'الرسالة',
        'domain'=>'النطاق',
        'facebook_url'=>'فيس بوك',
        'instagram_url'=>'انستجرام',
        'twitter_url'=>'توتير',
        'linkedin_url'=>'لينكدان',
        'snapchat_url'=>'سناب شات',
        'city_id'=>'المدينة',
        'title_ar'=>'العنوان عربي',
        'title_en'=>'العنوان انجليزي',
        'discount'=>'الخصم',
        'type'=>'النوع',
        'cities'=>'المدن',
        'map_key'=>'map key',
        'pusher_secret_key'=>'pusher secret key',
        'facebook_id'=>'facebook id',
        'facebook_secret_key'=>'facebook secret key',
        'google_id'=>'google id',
        'google_secret_key'=>'google secret key',
        'enable_recaptcha'=>'تفعيل التحقيق بسبب جوجول',
        'under_maintenance'=>'تحت الصيانة',
        'price_type'=>'نوع السعر',
        'currency_id'=>'العملة الاساسية',
        'seo_title_ar'=>'عنوان البحث عربي',
        'seo_title_en'=>'عنوان البحث انجليزي',
        'seo_description_ar'=>'وصف البحث عربي',
        'seo_description_en'=>'وصف البحث انجليزي',
        'logo'=>'الشعار',
        'seo_image'=>'صوره البحث',
        'value'=>'القيمة',
        'title_ar'=>'عنوان الصفحة عربي ',
        'title_en'=>'عنوان الصفحة انجلزي',
        'delivery_cost'=>'تكلفة التوصيل',
        'cash_is_open'=>'الدفع نقدأ',
        'online_payment_is_open'=>'الدفع اون لاين',
        'country_id'=>'الدولة' ,
        'view_stock'=>'عرض العدد الموجود من المنتج',
        'is_hidden'=>'اخفاء المنتج',
        'youtube_url'=>'رابط اليوتيوب',
        'video'=>'فيديو للمنتج',
        'main_image'=>'الصورة الرئيسية',
        'price_in_dollar'=>'السعر بالدولار',
        'price_in_pound'=>'السعر بالجنية',
        'price_in_sr'=>'السعر بالريال',
        'department_id'=>'القسم',
        'tax_id'=>'الضريبة',
        'colors'=>'الالوان',
        'sizes'=>'الاحجام',
        'in_stock'=>'العدد الموجود',
        'reminder_stock'=>'الحد الادني للنذكير',
        'delivery_times'=>'وقت التوصيل',
        'images'=>'الصور',
        'max_discount'=>'الحد الاقصي للخصم',
        'code'=>'الرمز',
        'countries'=>'الدول',
        'news_to'=>'أرسال الخبر الي' ,
        'about_us_ar'=>'عن الشركة عربي',
        'about_us_en'=>'عن الشركة انجليزي',
        'help_center'=>'مركز المساعدة',

        'fast_devlivery_ar'=>'توصيل اسرع بالعربية',
        'secure_payment_ar'=>'دفع امن بالعربية',
        'best_quality_ar'=>'افضل جوده بالعربية',
        'policy_return_ar'=>'سياسة الاسترجاع بالعربية',

        'fast_devlivery_en'=>'توصيل اسرع بالانجليزية',
        'secure_payment_en'=>'دفع امن بالانجليزية',
        'best_quality_en'=>'افضل جوده بالانجليزية',
        'policy_return_en'=>'سياسة الاسترجاع بالانجليزية',
        'product_id'=>'المنتج',
        'color'=>'اللون',
        'comment'=>'التعليق',
        'rate'=>'التقييم',
        'amount'=>'المبلغ',
        'from_text'=>'من',
        'to_text'=>'الي',
        'from'=>'من',
        'to'=>'الي',
        'service_id'=>'الخدمة',
        'occasion_id'=>'المناسبة',
        'payment_method_id'=>'طريقه الدفع',
        'total'=>'إجمالي السعر',
        'publish'=>'النشر',
        'notes'=>'ملاحظات',
        'mobile'=>"الهاتف" ,
        "main_image"=> "الصورة اﻻساسية",
        "goal_image"=> "صورة الهدف",
        "vision_image"=> "صورة الرؤية",
        "main_text_ar"=> "الرسالة اﻻساسية عربي",
        "main_text_en"=> "الرسالة الاساسية انجليزي",
        "seller_text_ar"=> "التاجر عربي",
        "seller_text_en"=> "التاجر انجليزي",
        "client_text_ar"=> "العميل عربي ",
        "client_text_en"=> "العميل انجليزي",
        "message_ar"=> "الرسالة عربي",
        "message_en"=> "الرسالة انجليزي",
        "goal_ar"=> "الهدف عربي",
        "goal_en"=> "الهدف انجليزي",
        "vision_ar"=> "الرؤية عربي",
        "vision_en"=> "الرؤية انجليزي",
        'blog_category_id'=>'required|exists:blog_categories,id',
        'author_name'=>'اسم الناشر',
        'summary'=>'الملخص',
        'title'=>'العنوان',
        'content'=>'المحتوي',
        'published_at'=>'تاريخ النشر',
        'slug'=>'',
        'slug_title'=>'',
    ],
];
