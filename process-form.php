<?php
/**
 * Created by 23rd and Walnut.
 * www.23andwalnut.com
 * User: Saleem El-Amin
 * Date: Aug 29, 2010
 * Time: 1:32:54 PM
 */


/** CONFIGURATION OPTIONS
 * $email_address = info@rechtsan
 * $company_address = The destination address that will be used in the contact form */

$email_address = 'infopost@rechtsanwaelte-hellmann.de';
$company_address = 'Triftweg 9, Oerlinghausen';



/** DO NOT EDIT ANYTHING BELOW THIS LINE UNLESS YOU ARE COMFORTABLE WITH PHP */

echo "<script>var companyAddress = '".$company_address."';</script>";

$field_rules = array(
    'name' => 'required',
    'email' => 'required|valid_email',
    'phone' => '',
    'contact_reason' => 'required',
    'message' => 'required'
);


$error_messages = array(
    'required' => 'Dieses Feld muss ausgefüllt werden',
    'valid_email' => 'Bitte geben Sie eine gültige E-Mail Adresse ein'
);


$error_list = '';


$fields = $_POST;



if (!empty($fields))
{
    //Validate each of the fields
    foreach ($field_rules as $field => $rules)
    {
        $rules = explode('|', $rules);

        foreach ($rules as $rule)
        {
            $result = null;

            if (isset($fields[$field]))
            {
                if (!empty($rule))
                    $result = $rule($fields[$field]);

                if ($result === false)
                {
                    $field_name = ucwords(implode(' ', explode('_', $field)));

                    $error_list .= "<div class='error'>$field_name: " . $error_messages[$rule] . "</div>";
                }
            }
        }
    }

    if (empty($error_list))
    {
        $subject = '[Contact Form] Neue Nachricht von ' . $fields['name'] . '.';

        $content = $fields['name'] . " sent you a message from your contact form:\r\n\n";
        $content .= "-------\n" . $fields['message'] . "\r\n\n";
        $content .= "Contact Reason: " . $fields['contact_reason']
                . " \n\nEmail: " . $fields['email']
                . " \n\nPhone: " . $fields['phone'] . " \n\n";

        if (mail($email_address, $subject, $content, "From: " . $fields['email'] . "\r\nReply-To: " . $fields['email'] . "\r\nReturn-Path: " . $fields['email'] . "\r\n"))
        {

            echo "<h2 class='success'>Nachricht versendet</h2>";
            echo "<br/><p class='success'>Vielen Dank <strong>" . $fields['name'] . "</strong>, Ihre Nachricht wurde uebermittelt. Wir werden uns in kuerze bei Ihnen melden.</p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
        }
        else
        {

            echo 'ERROR!';
        }
    }
}

function required($str, $val = false)
{

    if (!is_array($str))
    {
        $str = trim($str);
        return ($str == '') ? false : true;
    }
    else
    {
        return (!empty($str));
    }
}

function valid_email($str)
{
    return (!preg_match("/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD", $str)) ? false : true;
}
?>