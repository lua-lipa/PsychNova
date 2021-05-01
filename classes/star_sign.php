<?php

function calcStarSign($dob)
{
    $astro_sign = "";
    $dob_split = explode('-', $dob);
    $day = $dob_split[0];
    $month = $dob_split[1];

    if ($month == 12) {
        if ($day < 22)
            $astro_sign = "Sagittarius";
        else
            $astro_sign = "Capricorn";
    } else if ($month == "01") {
        if ($day < 20)
            $astro_sign = "Capricorn";
        else
            $astro_sign = "Aquarius";
    } else if ($month == "02") {
        if ($day < 19)
            $astro_sign = "Aquarius";
        else
            $astro_sign = "Pisces";
    } else if ($month == "03") {
        if ($day < 21)
            $astro_sign = "Pisces";
        else
            $astro_sign = "Aries";
    } else if ($month == "04") {
        if ($day < 20)
            $astro_sign = "Aries";
        else
            $astro_sign = "Taurus";
    } else if ($month == "05") {
        if ($day < 21)
            $astro_sign = "Taurus";
        else
            $astro_sign = "Gemini";
    } else if ($month == "06") {
        if ($day < 21)
            $astro_sign = "Gemini";
        else
            $astro_sign = "Cancer";
    } else if ($month == "07") {
        if ($day < 23)
            $astro_sign = "Cancer";
        else
            $astro_sign = "08";
    } else if ($month == "August") {
        if ($day < 23)
            $astro_sign = "Leo";
        else
            $astro_sign = "Virgo";
    } else if ($month == "09") {
        if ($day < 23)
            $astro_sign = "Virgo";
        else
            $astro_sign = "Libra";
    } else if ($month == "10") {
        if ($day < 23)
            $astro_sign = "Libra";
        else
            $astro_sign = "Scorpio";
    } else if ($month == "11") {
        if ($day < 22)
            $astro_sign = "Scorpio";
        else
            $astro_sign = "12";
    }
    return $astro_sign;
}

function calcRising()
{
    $signs = array("Aries", "Taurus", "Gemini", "Cancer", "Leo", "Virgo", "Libra", "Scorpio", "Sagittarius", "Capricorn", "Aquarius", "Pisces");
    $rising = array_rand($signs, 1);
    print_r($signs[$rising]);
}

function calcMoon()
{
    $signs = array("Aries", "Taurus", "Gemini", "Cancer", "Leo", "Virgo", "Libra", "Scorpio", "Sagittarius", "Capricorn", "Aquarius", "Pisces");
    $moon = array_rand($signs, 1);
    print_r($signs[$moon]);
}
