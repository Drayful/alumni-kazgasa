<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ContributionController extends Controller
{
    public function index(): View
    {
        $contributions = [
            [
                'fio' => 'Хасенов Манас Игенович',
                'year' => '1989 г. группа АС-84',
                'position' => 'Декан ША МОК, ассоц. профессор',
                'description_title' => 'Именная аудитория №531',
                'initiators' => 'Инициаторы: выпускники групп АС-82–84',
                'description' => 'Аудитория №531 открыта по инициативе выпускников, которые спустя годы решили оставить свой след в Альма-матер. Сегодня это пространство носит их имя и служит напоминанием нынешним студентам: здесь учились те, кто строил нашу страну.',
                'what_done' => [
                    'Организован ремонт и обновление аудитории',
                    'Установлена мемориальная табличка',
                    'Создано комфортное пространство для занятий',
                ],
                'note' => null,
                'photo' => asset('images/contributions/image1.png'),
            ],
            [
                'fio' => 'Хасенов Манас Игенович',
                'year' => '1989 г. группа АС-84',
                'position' => 'Декан ША МОК, ассоц. профессор',
                'description_title' => 'Именная аудитория №539',
                'initiators' => 'В память о: Монтахаеве К.Ж. — выпускнике, оставившем яркий след в жизни университета',
                'description' => 'Аудитория №539 открыта в память о выпускнике, чьи профессиональные и человеческие качества стали примером для многих поколений. Это место — дань уважения и символ преемственности традиций.',
                'what_done' => [
                    'Инициировано и организовано открытие именной аудитории',
                    'Проведено обновление пространства',
                    'Установлена памятная табличка',
                ],
                'note' => null,
                'photo' => asset('images/contributions/image2.png'),
            ],
            [
                'fio' => 'Хасенов Манас Игенович',
                'year' => '1989 г. группа АС-84',
                'position' => 'Декан ША МОК, ассоц. профессор',
                'description_title' => null,
                'initiators' => 'Инициаторы: выпускники разных лет',
                'description' => 'Выпускники организовали посадку деревьев на территории Международной образовательной корпорации. Каждое дерево — это живой след, который будет расти вместе с университетом и новыми поколениями студентов.',
                'what_done' => [
                    'Организована посадка деревьев',
                    'Выбраны места для озеленения',
                    'Проведены работы по благоустройству территории',
                ],
                'note' => 'Голубая ель 3 шт. (н-1.8м)',
                'photo' => asset('images/contributions/image3.png'),
            ],
            [
                'fio' => 'Хасенов Манас Игенович',
                'year' => '1989 г. группа АС-84',
                'position' => 'Декан ША МОК, ассоц. профессор',
                'description_title' => 'Вставить то, что сверху',
                'initiators' => null,
                'description' => null,
                'what_done' => [],
                'note' => null,
                'photo' => asset('images/contributions/image4.png'),
            ],
            [
                'fio' => 'Ахметов Ержан Абдирахманович',
                'year' => '1991 г. с группой выпускников АС-84',
                'position' => 'Ассоц. профессор кафедры ГОП ША',
                'description_title' => 'Вставить то, что сверху',
                'initiators' => null,
                'description' => null,
                'what_done' => [],
                'note' => null,
                'photo' => asset('images/contributions/image5.png'),
            ],
            [
                'fio' => 'Ахметов Ержан Абдирахманович',
                'year' => '1991 г. группой выпускников АС-86',
                'position' => 'Специалист, ассоц. профессор кафедры ГОП ША',
                'description_title' => 'Вставить то, что сверху',
                'initiators' => null,
                'description' => null,
                'what_done' => [],
                'note' => null,
                'photo' => asset('images/contributions/image6.png'),
            ],
            [
                'fio' => 'Ахметов Ержан Абдирахманович',
                'year' => '1991 г. с группой выпускников АС-84',
                'position' => 'Специалист, ассоц. профессор кафедры ГОП ША',
                'description_title' => 'Вставить то, что сверху',
                'initiators' => null,
                'description' => null,
                'what_done' => [],
                'note' => 'Голубая ель 3 шт. (н-1.8м)',
                'photo' => asset('images/contributions/image1.png'),
            ],
            [
                'fio' => 'Ахметов Ержан Абдирахманович',
                'year' => '1991 г. с группой выпускников АС-86',
                'position' => 'Специалист, ассоц. профессор кафедры ГОП ША',
                'description_title' => 'Вставить то, что сверху',
                'initiators' => null,
                'description' => null,
                'what_done' => [],
                'note' => 'Не будем дублировать. Зеленная ель 3 шт. (н-1.8м)',
                'photo' => asset('images/contributions/image2.png'),
            ],
        ];

        return view('contributions.index', compact('contributions'));
    }
}

