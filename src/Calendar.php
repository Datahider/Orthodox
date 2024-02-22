<?php

namespace losthost\Orthodox;
use DateTimeInterface;
use stdClass;

/**
 * Получение названий дней православного календаря
 *
 * @author drweb_000
 */
class Calendar {

    const KIRYGMA = 1;
    const LECTURE = 2;
    const DISCUSSION = 3;
    const READINGS = 4;
    
    const EVENING_STARTS = '16:00';
    
    const MONTHS_1 = ['', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
    const MONTHS_2 = ['', 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
   
    const WEEKDAYS_REGULAR = [ "Неделя", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ];
    const WEEKDAYS_GREAT = [ "", "Великий Понедельник", "Великий Вторник", "Великая Среда", "Великий Четверг", "Великая Пятница", "Великая Суббота" ];
    const WEEKDAYW_LIGHT = [ "Светлое Христово Воскресенье. Пасха", "Светлый Понедельник", "Светлый Вторник", "Светлая Среда", "Светлый Четверг", "Светлая Пятница", "Светлая Суббота" ];
    
    const PERIOD_PENTECOST  = 0;
    const PERIOD_EASTER     = 1;
    const PERIOD_LIGHT      = 2; 
    const PERIOD_GREAT      = 3; 
    const PERIOD_LENT       = 4;
    const PERIOD_PREP       = 5;
    const PERIOD_OTHER      = 6;
    
    const PERIODS = ['по Пятидесятнице', 'по Пасхе', 'Светлая', 'Великая', 'Великого Поста', 'Приуготовительная к Великому Посту', 'по Пятидесятнице'];
    
    protected $prep_sundays = [
        1 => 'Неделя о мытаре и фарисее. Поминовение усопших.',
        2 => 'Неделя о блудном сыне.',
        3 => 'Неделя мясопустная. О Страшном суде.',
        4 => 'Неделя сыропустная. Прощеное воскресенье.',
    ];
    
    protected $lent_sundays = [
        1 => 'Неделя 1-я Великого поста. Торжество Православия.', 
        2 => 'Неделя 2-я Великого поста. Святителя Григория Паламы.',
        3 => 'Неделя 3-я Великого поста. Крестопоклонная.',
        4 => 'Неделя 4-я Великого поста. Преподобного Иоанна Лествичника.',
        5 => 'Неделя 5-я Великого поста. Преподобной Марии Египетской.',
        6 => 'Неделя 6-я Великого поста. Вход Господень в Иерусалим, неделя ваий.',
    ];
    
    protected $easter_sundays = [
        2 => 'Неделя 2-я по Пасхе. Апостола Фомы (Антипасха).',
        3 => 'Неделя 3-я по Пасхе. Свв. жен-мироносиц.',
        4 => 'Неделя 4-я по Пасхе. О расслабленном.',
        5 => 'Неделя 5-я по Пасхе. О самаряныне.',
        6 => 'Неделя 6-я по Пасхе. О слепом.',
        7 => 'Неделя 7-я по Пасхе. Святых отцов I Вселенского Собора.',
        8 => 'Неделя 8-я по Пасхе. День Святой Троицы. Пятидесятница.',
    ];


    const EASTER_DATES = [
        '2021' => '02.05.2021',
        '2022' => '24.04.2022',
        '2023' => '16.04.2023',
        '2024' => '05.05.2024',
        '2025' => '20.04.2025',
        '2026' => '12.04.2026',
        '2027' => '02.05.2027',
        '2028' => '16.04.2028',
        '2029' => '08.04.2029',
        '2030' => '28.04.2030',
        '2031' => '13.04.2031',
        '2032' => '02.05.2032',
        '2033' => '24.04.2033',
        '2034' => '09.04.2034',
        '2035' => '29.04.2035',
    ];


    private $year;
    private $mon; 
    private $day; 
    private $wday;
    private $doy;
    private $easter_doy;
    private $pentecost_doy;
    private $period;


    public function getDayAsObject(DateTimeInterface $datetime) : stdClass {
        $r = new stdClass();
        $r->datetime = $datetime;
        $r->year = $datetime->format('Y');
        $r->doy = (int) $datetime->format('z');
        $r->easter_doy = (int) date_create(static::EASTER_DATES[$r->year])->format('z');
        $r->pentecost_doy = $r->easter_doy + 49;
        $r->wday = (int) $datetime->format("w");
        $r->wday_name = $this->weekday($r);
        $r->mon = $datetime->format('m');
        $r->mon_name1 = static::MONTHS_1[(int)$r->mon];
        $r->mon_name2 = static::MONTHS_2[(int)$r->mon];
        $r->day = $datetime->format('d');
        $r->period = $this->computePeriod($r);
        $r->period_name = static::PERIODS[$r->period];
        $r->week_number = $this->week($r);
        return $r;
    }
   
    public function getDayAsText(DateTimeInterface $datetime) : string {
        $r = $this->getDayAsObject($datetime);

        if ($r->period == static::PERIOD_PREP) {
            if ( $r->wday != 0) {
                return <<<END
                    $r->day $r->mon_name2. $r->wday_name.
                    $r->week_number-я приуготовительная седмица к Великому Посту.
                    END;
            } else {
                return <<<END
                    $r->day $r->mon_name2. {$this->prep_sundays[$r->week_number]}
                    END;
            }
        } elseif ($r->period == static::PERIOD_GREAT) {
            return <<<END
                $r->day $r->mon_name2. $r->wday_name Страстной седмицы.
                END;
        } elseif ($r->period == static::PERIOD_LIGHT) {
            if ($r->wday == 0) {
                return "$r->day $r->mon_name2. $r->wday_name";
            }
            return <<<END
                $r->day $r->mon_name2. $r->wday_name.
                Светлая седмица.    
                END;
        } elseif ($r->wday == 0) {
            if ($r->period == static::PERIOD_LENT) {
                return "$r->day $r->mon_name2. {$this->lent_sundays[$r->week_number]}";
            } elseif ($r->period == static::PERIOD_EASTER) {
                return "$r->day $r->mon_name2. {$this->easter_sundays[$r->week_number]}";
            }
            return "$r->day $r->mon_name2. $r->wday_name $r->week_number-я $r->period_name.";
        }

        return <<<END
            $r->day $r->mon_name2. $r->wday_name
            Седмица $r->week_number-я $r->period_name.
            END;
    }
    
    protected function mod($param) {
        if (isset(self::MODS[$param])) {
            return self::MODS[$param];
        }
        
        return $param;
    }
    
    protected function week($obj) : int {
        if ($obj->period == static::PERIOD_PENTECOST) {
            return (int) (floor($obj->doy + 6 - $obj->pentecost_doy) / 7);
        } elseif ($obj->period == static::PERIOD_OTHER) {
            $last_pentecost_doy = 49 + date_create(static::EASTER_DATES[$obj->year-1])->format('z');
            $last_year_day = date_create(($obj->year-1). '-12-31')->format('z');
            return (int) (floor($obj->doy + 7 + $last_year_day-$last_pentecost_doy) / 7);
        } elseif ($obj->period == static::PERIOD_PREP) {
            return (int) (floor($obj->doy - $obj->easter_doy + 77) / 7);
        } elseif ($obj->period == static::PERIOD_LENT) {
            return (int) (floor($obj->doy - $obj->easter_doy + 55) / 7);
        } elseif ($obj->period == static::PERIOD_EASTER) {
            return (int) (floor($obj->doy - $obj->easter_doy + 7) / 7);
        }
        return false;
    }
    
    function getTitleObject($datetime, $recording_type) {
        $this->datetime_object = new DateTime($datetime);
        
        switch ($recording_type) {
            case self::KIRYGMA:
                return $this->getTitleKirygma($datetime_object);
            case self::LECTURE:
                return $this->getTitleLecture($datetime_object);
            case self::DISCUSSION:
                return $this->getTitleDiscussion($datetime_object);
            case self::READINGS:
                return $this->getTitleReadings($datetime_object);
            default:
                throw new Exception("Incorrect recording type given: $recording_type", -10003);
        }
    }
    
    private function weekday(stdClass $obj) {
        if ($obj->doy < $obj->easter_doy) {
            if ($obj->easter_doy - $obj->doy < 7) {
                return static::WEEKDAYS_GREAT[$obj->wday];
            } else {
                return static::WEEKDAYS_REGULAR[$obj->wday];
            }
        } else {
            if ($obj->doy - $obj->easter_doy < 7) {
                return static::WEEKDAYW_LIGHT[$obj->wday];
            } else {
                return static::WEEKDAYS_REGULAR[$obj->wday];
            }
        }
    }
    
    private function computePeriod($obj) {
        if ($obj->doy > $obj->pentecost_doy) {
            return static::PERIOD_PENTECOST;
        } elseif ($obj->doy >= $obj->easter_doy+7) {
            return static::PERIOD_EASTER;
        } elseif ($obj->doy >= $obj->easter_doy) {
            return static::PERIOD_LIGHT;
        } elseif ($obj->doy >= $obj->easter_doy-6) {
            return static::PERIOD_GREAT;
        } elseif ($obj->doy >= $obj->easter_doy-48) {
            return static::PERIOD_LENT;
        } elseif ($obj->doy >= $obj->easter_doy-70) {
            return static::PERIOD_PREP;
        } else {
            return static::PERIOD_OTHER; // Нужен не простой рассчет дней по прошлогодней Пятидесятнице
        }
    }
    
    private function getTitleKirygma($datetime) {
        return "!!!---НАЗВАНИЕ ДНЯ ДЛЯ ПРОПОВЕДИ---!!!";
    }
    private function getTitleLecture($datetime) {
        return "!!!---НАЗВАНИЕ ДНЯ ДЛЯ ЛЕКЦИИ---!!!";
    }
    private function getTitleDiscussion($datetime) {
        return "!!!---НАЗВАНИЕ ДНЯ ДЛЯ БЕСЕДЫ---!!!";
    }
    private function getTitleReadings($datetime) {
        return "!!!---НАЗВАНИЕ ДНЯ ДЛЯ ЕВАНГЕЛЬСКИХ ЧТЕНИЙ---!!!";
    }
    
    protected function isEveningTime($datetime) {
        if ($datetime->format("H:i") >= static::EVENING_STARTS) {
            return true;
        }
        return false;
    }
    
}
