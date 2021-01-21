<?php

const SPAM_DOMAINS = ['spamming.com', 'mailinator.com', 'oneminutemail.com'];
const EMAIL_PARAM_NAME = 'email';

try {
    $email = GetParam(EMAIL_PARAM_NAME, true);

    EmailIsValid($email, true);

    $domain = GetEmailDomain($email, true);

    if (IsDomainAccepted($domain)) {
        echo "Email is valid";
    } else {
        throw new Exception("Email is spam");
    }

} catch (Exception $e) {
    echo $e->getMessage();
}

function IsDomainAccepted(string $domainToCheck)
{
    if (!in_array($domainToCheck, SPAM_DOMAINS)) {
        return true;
    }
    return false;
}


function HasGetParam(string $parameterName)
{
    if (!empty($_GET) && !empty($_GET[$parameterName])) {
        return true;
    }
    return false;
}

function GetParam(string $parameterName, bool $throwError = false)
{
    if (HasGetParam($parameterName)) {
        return $_GET[$parameterName];
    }
    if ($throwError) {
        throw new Exception("Please provide a valid email address");
    }
    return true;
}

function EmailIsValid(string $email, bool $throwError = false)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }

    if ($throwError) {
        throw new Exception("Invalid email address");
    }

    return false;
}

function GetEmailDomain($email, bool $throwError = false)
{
    if (HasDomain($email)) {
        $emailParts = explode('@', $email);
        return $emailParts[1];
    }
    if ($throwError) {
        throw new Exception("Unable to extract domain from email address");
    }
    return null;
}


function HasDomain(string $email)
{
    $emailParts = explode('@', $email);
    if ($emailParts == true && count($emailParts) === 2) {
        return true;
    }
    return false;
}
