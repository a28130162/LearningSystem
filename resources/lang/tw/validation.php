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

    'accepted' => '必須被接受',
    'active_url' => '不是有效的網址。',
    'after' => '必須是 :date 之後的日期。',
    'after_or_equal' => '必須是等於或 :date 之後的日期。',
    'alpha' => '必須只能包含字母。',
    'alpha_dash' => '只能包含字母、數字、破折號或下劃線。',
    'alpha_num' => '只能包含字母和數字。',
    'array' => '必須是一個數列。',
    'before' => '必須是 :date 之前的日期。',
    'before_or_equal' => '必須是等於或 :date 之前的日期。',
    'between' => [
        'numeric' => '必須介於 :min 和 :max 之間。',
        'file' => '必須介於 :min KB和 :max KB之間。',
        'string' => '必須介於 :min 字元和 :max 個字元之間。',
        'array' => '必須介於 :min 和 :max 個項目之間。',
    ],
    'boolean' => '必須是 true 或 false。',
    'confirmed' => '確認不一致。',
    'date' => '不是有效的日期。',
    'date_equals' => ':attribute 必須是等於 :date 的日期。',
    'date_format' => ':attribute 與格式 :format 不一致。',
    'different' => ':attribute 和 :other 必須為不同。',
    'digits' => '必須為數字 :digits 。',
    'digits_between' => '必須介於數字 :min 和 :max 之間。',
    'dimensions' => ':attribute 的圖片尺寸無效。',
    'distinct' => ':attribute 字段具有重複值。',
    'email' => '必須是有效的電子郵件地址',
    'ends_with' => '必須以以下其中之一結尾： :values。',
    'exists' => '所選擇的 :attribute 無效。',
    'file' => '必須是一個文件。',
    'filled' => ':attribute 字段必須有一個值。',
    'gt' => [
        'numeric' => '必須大於 :value。',
        'file' => '必須大於 :value KB。',
        'string' => '必須大於 :value 個字元。',
        'array' => '必須包含 :value 個以上的項目。',
    ],
    'gte' => [
        'numeric' => '必須大於或等於 :value。',
        'file' => '必須大於或等於 :value KB。',
        'string' => '必須大於或等於 :value 個字元。',
        'array' => '必須有 :value 個或更多項目。',
    ],
    'image' => '必須是圖片。',
    'in' => '所選的 :attribute 無效。',
    'in_array' => ':attribute 不存在於 :other 之中。',
    'integer' => ':attribute 必須是整數。',
    'ip' => '必須是有效的IP位置。',
    'ipv4' => '必須是有效的 IPv4 位置。',
    'ipv6' => '必須是有效的 IPv6 位置。',
    'json' => '必須是有效的 JSON 字串。',
    'lt' => [
        'numeric' => '必須小於 :value。',
        'file' => '必須小於 :value KB。',
        'string' => ':attribute 必須小於 :value 個字元。',
        'array' => '必須少於 :value 個項目。',
    ],
    'lte' => [
        'numeric' => '必須小於或等於 :value。',
        'file' => '必須小於或等於 :value KB。',
        'string' => '必須小於或等於 :value 個字元。',
        'array' => '必須有少於或等於 :value 個項目。',
    ],
    'max' => [
        'numeric' => '不得大於 :max。',
        'file' => '不得大於 :max KB。',
        'string' => '不得大於 :max 個字元。',
        'array' => '不得多於 :max 個項目。',
    ],
    'mimes' => '必須是以下類型的文件： :values。',
    'mimetypes' => '必須是類型 :values 的文件。',
    'min' => [
        'numeric' => '必須至少為 :min。',
        'file' => '必須至少有 :min KB。',
        'string' => '必須至少有 :min 個字元。',
        'array' => '必須至少有 :min 個項目。',
    ],
    'multiple_of' => '必須是 :value 的倍數。',
    'not_in' => '所選擇的 :attribute 無效。',
    'not_regex' => '格式無效。',
    'numeric' => '必須是數字。',
    'password' => '密碼不正確。',
    'present' => '必須存在 :attribute 字段。',
    'regex' => '屬性格式無效。',
    'required' => '此欄位為必填屬性。',
    'required_if' => '當 :other 為 :value 時， :attribute 為必填屬性。',
    'required_unless' => ':attribute 為必填屬性，除非 :other 位於 :values 之中。',
    'required_with' => ':values 如果存在，則必須使用 :attribute 字段。',
    'required_with_all' => '若存在 :values 時， :attribute 為必填屬性。',
    'required_without' => ':values 如果不存在， :attribute 為必填屬性。',
    'required_without_all' => '若 :values 都不存在， :attribute 為必填屬性。',
    'prohibited' => ':attribute 字段被禁止。',
    'prohibited_if' => '當 :other 是 :value 時， :attribute 字段被禁止。',
    'prohibited_unless' => '除非 :other 放在 :values 之中，否則 :attribute 字段被禁止。',
    'same' => ':attribute 和 :other 必須一致。',
    'size' => [
        'numeric' => '必須為 :size。',
        'file' => '必須為 :size KB。',
        'string' => '必須為 :size 個字元。',
        'array' => '必須有 :size 個項目。',
    ],
    'starts_with' => '必須以以下其中一項開頭： :values。',
    'string' => '必須為字串。',
    'timezone' => '必須是有效區域。',
    'unique' => '此名稱已被使用。',
    'uploaded' => '上傳失敗。',
    'url' => '屬性格式無效。',
    'uuid' => '必須是有效的 UUID。',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
