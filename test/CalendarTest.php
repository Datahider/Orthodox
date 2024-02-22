<?php
namespace losthost\Orthodox\test;
use losthost\Orthodox\Calendar;
use PHPUnit\Framework\TestCase;

/**
 * Description of CalendarTest
 *
 * @author drweb_000
 */
class CalendarTest extends TestCase {
    
    public function testCalendarCases() {
        
        $cases2022 = file_get_contents("2022cases.txt");
        $cases2023 = file_get_contents("2023cases.txt");
        
        $this->assertNotFalse($cases2022);
        $this->assertNotFalse($cases2023);
    }
    
    public function testSomeDates() {
        
        $t = new TranslitCalendar();
        
//        print_r($t->getDayAsObject(date_create("2022-01-04")));
//        print_r($t->getDayAsObject(date_create("2022-06-18")));
//        print_r($t->getDayAsObject(date_create("2022-06-26")));
//        print_r($t->getDayAsObject(date_create("2022-06-27")));
//        print_r($t->getDayAsObject(date_create("2022-07-16")));
//        print_r($t->getDayAsObject(date_create("2022-07-17")));
//        print_r($t->getDayAsObject(date_create("2022-07-18")));
//        print_r($t->getDayAsObject(date_create("2022-04-04")));
//        print_r($t->getDayAsObject(date_create("2022-04-20")));
//        print_r($t->getDayAsObject(date_create("2022-04-24")));
        print_r($t->getDayAsText(date_create("2023-01-08")));
        print_r($t->getDayAsText(date_create("2023-01-09")));
        print_r($t->getDayAsText(date_create("2023-01-10")));
    }
}
