<?php

namespace losthost\Orthodox\test;
use losthost\Orthodox\Calendar;

/**
 * Description of TranslitCalendar
 *
 * @author drweb_000
 */
class TranslitCalendar extends Calendar {
    
    const MONTHS_1 = ['Janvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentiabr', 'Oktiabr', 'Noyabr', 'Dekabr'];
    const MONTHS_2 = ['Janvaria', 'Fevralia', 'Marta', 'Aprelia', 'Maya', 'Iyunia', 'Iyulia', 'Avgusta', 'Sentiabria', 'Oktiabria', 'Noyabria', 'Dekabria'];
   
    const WEEKDAYS_REGULAR = [ "Nedelia", "Ponedelnik", "Vtornik", "Sreda", "Chetverg", "Piatnitsa", "Subbota" ];
    const WEEKDAYS_GREAT = [ "", "Velikiy Ponedelnik", "Velikiy Vtornik", "Velikaya Sreda", "Velikiy Chetverg", "Velikaya Piatnitsa", "Velikaya Subbota" ];
    const WEEKDAYW_LIGHT = [ "Svetloe Voskresenie", "Svetliy Ponedelnik", "Svetliy Vtornik", "Svetlaya Sreda", "Svetliy Chetverg", "Svetlaya Piatnitsa", "Svetlaya Subbota" ];
    
    const PERIODS = ['po Piatidesiatnitse', 'po Paskhe', 'Svetlaya', 'Velikaya', 'Velikogo Posta', 'Priugotovitelnaya k Velikomu Postu', 'po Piatidesiatnitse'];
    
}
