
<?php
return [
    'VLDT_MSG' => [
        'required' 		    => 'Required field missing',
        'unique' 			=> 'Already exist, Please try another',
        'alpha' 			=> 'Only alphabetic characters allowed',
        'digits' 			=> 'Minimum :digits numeric characters allowed',
        'min'				=> 'To sort, at least :min characters',
        'max'				=> 'To long, max :max characters',
        'mimes'				=> 'Valid Image Upload Format : PNG, JPG, JPEG',
        'integer' 			=> 'Must be an integer',
        'numeric'           => 'Only numeric characters allowed',
        'same'              => 'Confirm password did not matched.',
        'accepted'          => 'Accept Terms & Conditions',
        'sUserEmail.regex'	=> 'Invalid email address, Capital letter not allowed',
        'sUserPswrd.regex' 	=> 'Should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.',
        'sCnfrmPass.regex'  => 'Should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.',
        'sUserName.regex'   => 'Only alphabetic characters allowed',
        'sFullName.regex'   => 'Only alphabetic characters allowed',
        'sEmailId.regex'    => 'Invalid email address, Capital letter not allowed',
        'sBussName.regex'   => 'Only alphabetic characters allowed',
        'sFrstName.regex'   => 'Only alphabetic characters allowed',
        'sLstName.regex'    => 'Only alphabetic characters allowed',
        'sStrtName.regex'   => 'Only alphabetic characters allowed',
        'sCompName.regex'   => 'Only alphabetic characters allowed',
        'sRoleName.regex'   => 'Only alphabetic characters allowed',
        'suburb.regex'      => 'Only alphabetic characters allowed',
        'sActvDate.unique'  => 'Already exist with selected state, Please try another.',
    ],

    'DEL_STATUS' => [
        "DELETED"   => 209,
        "UNDELETED" => 210,
    ],

    "MONTH"	=> [
        "1"		=> "JAN",
        "2"		=> "FEB",
        "3"		=> "MAR",
        "4"		=> "APR",
        "5"		=> "MAY",
        "6"		=> "JUN",
        "7"		=> "JUL",
        "8"		=> "AUG",
        "9"		=> "SEP",
        "10"	=> "OCT",
        "11"	=> "NOV",
        "12"	=> "DEC",
    ],

    'STATUS' => [
        "BLOCK"   => 109,
        "UNBLOCK" => 110,
    ],

    'EMAIL_STATUS' => [
        "UNVERIFIED" => 309,
        "VERIFIED"   => 310,
    ],

    'APPROVAL_STATUS' => [
        "REJECTED" => 409,
        "APPROVED"   => 410,
        "UNKNOWN"   => 411,
    ],

    "TAX_MTHD"  => [
        "VAT"   => 201,
        "GST"   => 202,
    ],

    'PLAN_SUBSCRIPTION' => [
        "ACTIVATE"      => 121,
        "DEACTIVATE"    => 122,
    ],

    'EMAIL_SUBSCRIPTION' => [
        "YES"      => 126,
        "NO"    => 127,
    ],

    'MEMBER_TYPE' => [
        "STAFF"   => 211,
        "VISITOR" => 212,
    ],

    'USER_TYPE' => [
        "ADMINISTRATOR" => 401,
        "OPERATOR"      => 402,
        "ENGINEER"      => 403,
        "MANAGER"       => 404,
    ],

    'GNDR_IDNO' => [
        "MALE"      => 1001,
        "FEMALE"    => 1002,
        "OTHER"     => 1003,
    ],

    'BUSS_TYPE' => [
        "IND"   => 302,
    ],

    'VISITOR_TYPE' => [
        "STAFF"   => "ST166",
        "GUEST"   => "GU512",
    ],
]
?>
