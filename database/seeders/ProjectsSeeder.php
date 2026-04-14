<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'sort_order' => 10,
                'is_active' => true,
                'icon' => '🎓',
                'translations' => [
                    'ru' => [
                        'title' => 'Гостевые лекции от практиков',
                        'tags' => 'Знания · Бренд · Влияние',
                        'button_text' => 'Хочу провести лекцию',
                        'short' => 'Вы делитесь реальными кейсами - студенты получают то, чего нет в учебниках. Организацию, запись и продвижение берём на себя.',
                        'how_it_works' => 'Только актуальные темы, которые можно применить здесь и сейчас. Формат гибкий: офлайн в стенах КазГАСА или онлайн. Мы берём на себя всё: организацию, техническое сопровождение, запись и продвижение в медиа Академии.',
                        'what_you_get' => 'Вы становитесь голосом индустрии - человеком, на которого ориентируется новое поколение. Это работает на личный бренд и узнаваемость компании.',
                    ],
                    'kk' => [
                        'title' => 'Тәжірибелі мамандардан қонақ дәрістер',
                        'tags' => 'Білім · Бренд · Ықпал',
                        'button_text' => 'Дәріс өткізгім келеді',
                        'short' => 'Сіз нақты кейстермен бөлісесіз, ал студенттер оқулықта жоқ нәрсені біледі. Ұйымдастыру, жазып алу әрі ілгерілету жағын өз мойнымызға аламыз.',
                        'how_it_works' => 'Тек қазір және осы жерде қолдануға болатын өзекті тақырыптар. Өту форматы: ҚазБСҚА қабырғасында офлайн немесе онлайн. Біз бәрін өз мойнымызға аламыз: ұйымдастыру, техникалық қолдау, жазба және Академия медиасында жылжыту.',
                        'what_you_get' => 'Сіз индустрия үніне – жаңа буын өкілі үлгі алатын адамға айналасыз. Бұл жеке бренд пен компания атын шығару бағытында жұмыс істейді.',
                    ],
                    'en' => [
                        'title' => 'Guest Lectures by Practitioners',
                        'tags' => 'Knowledge · Brand · Impact',
                        'button_text' => 'I want to give a lecture',
                        'short' => 'You share real cases - students receive what no textbook can offer. We handle all organisation, recording and promotion.',
                        'how_it_works' => 'Only relevant topics applicable here and now. The format is flexible: offline within KazGASA or online. We take care of everything: organisation, technical support, recording and promotion across Academy media.',
                        'what_you_get' => 'You become the voice of the industry - a person the next generation looks up to. This strengthens your personal brand and your company\'s visibility.',
                    ],
                ],
            ],
            [
                'sort_order' => 20,
                'is_active' => true,
                'icon' => '🤝',
                'translations' => [
                    'ru' => [
                        'title' => 'Лига Наставников',
                        'tags' => 'Наставничество · Кадры · Медиа',
                        'button_text' => 'Стать наставником',
                        'short' => 'Прямой мост между вами и лучшими студентами. Вы помогаете молодому специалисту найти путь - и первым видите, из кого вырастет следующий лидер.',
                        'how_it_works' => 'Наставничество - это не обязательство. Это возможность. Формат: личная беседа, воркшоп или онлайн-сессия. Можно делегировать перспективному сотруднику. Факт: студенты с наставником на 20–25% более вовлечены (Chronus).',
                        'what_you_get' => 'Прямой доступ к лучшим умам нового поколения. Возможность формировать кадры под задачи своей компании.',
                    ],
                    'kk' => [
                        'title' => 'Тәлімгерлер лигасы',
                        'tags' => 'Тәлімгерлік · Кадрлар · Медиа',
                        'button_text' => 'Тәлімгер болу',
                        'short' => 'Үздік студенттермен қарым-қатынас орнатудың тікелей көпірі. Сіз жас маманға жол көрсетіп, кімнің көшбасшы болатынын бірден байқайсыз.',
                        'how_it_works' => 'Тәлімгерлік – міндет емес. Бұл – мүмкіндік. Форматы: бетпе-бет әңгімелесу, воркшоп немесе онлайн-сессия. Бұл істі болашағы бар қызметкерге тапсыруға болады. Дерек: студенттер тәлімгермен бірге 20–25%-ға белсенді болады (Chronus).',
                        'what_you_get' => 'Ойы ұшқыр жаңа буынмен тікелей жұмыс істеу. Компанияның мүддесіне сай кадрлар даярлау мүмкіндігі.',
                    ],
                    'en' => [
                        'title' => 'Mentors League',
                        'tags' => 'Mentorship · Talent · Media',
                        'button_text' => 'Become a Mentor',
                        'short' => 'A direct bridge between you and the best students. You help a young professional find their path - and are the first to see who the next leader will be.',
                        'how_it_works' => 'Mentorship is not an obligation - it is an opportunity. Format: one-on-one conversation, workshop or online session. You may delegate to a promising employee. Fact: students with a mentor are 20–25% more engaged (Chronus).',
                        'what_you_get' => 'Direct access to the brightest minds of the next generation. The opportunity to shape talent aligned with your company\'s needs.',
                    ],
                ],
            ],
            [
                'sort_order' => 30,
                'is_active' => true,
                'icon' => '🏆',
                'translations' => [
                    'ru' => [
                        'title' => '45 Именных стипендий',
                        'tags' => 'Стипендия · Наследие · Инвестиция',
                        'button_text' => 'Учредить стипендию',
                        'short' => 'Учредите стипендию своего имени или имени компании. Ваш стипендиат - не просто получатель помощи, а человек, с которым вы строите будущее вместе.',
                        'how_it_works' => 'В честь 45-летия КазГАСА открываем 45 именных стипендий. Вы выбираете талантливого студента, получаете отчёты о его прогрессе. Это инвестиция в конкретного будущего лидера. Факт: целевые стипендии с наставничеством значительно повышают шансы на успешную карьеру (Всемирный банк, UNESCO).',
                        'what_you_get' => 'Личная история успеха, связанная с вашим именем. Узнаваемость внутри сообщества КазГАСА.',
                    ],
                    'kk' => [
                        'title' => '45 Атаулы стипендия',
                        'tags' => 'Стипендия · Мұра · Инвестиция',
                        'button_text' => 'Стипендия тағайындау',
                        'short' => 'Өз атыңыздан немесе компания атынан стипендиясы тағайындаңыз. Стипендиатыңыз – көмек алушы ғана емес, болашағыңызды бірге құратын жан.',
                        'how_it_works' => 'ҚазБСҚА-ның 45 жылдығы құрметіне 45 атаулы стипендия жариялаймыз. Сіз дарынды студентті таңдап, оның ілгерілеуі қамтылған есептерді аласыз. Бұл болашақ көшбасшыға салынған нақты инвестиция. Дерек: тәлімгерлік үшін берілетін нысаналы стипендиялар табысты мансап құру мүмкіндігін арттырады (Дүниежүзілік банк, UNESCO).',
                        'what_you_get' => 'Жеткен жетістіктеріңіздің тарихы. KazGASA қауымдастығы ішінде танымал болу.',
                    ],
                    'en' => [
                        'title' => '45 Named Scholarships',
                        'tags' => 'Scholarship · Legacy · Investment',
                        'button_text' => 'Establish a Scholarship',
                        'short' => 'Establish a scholarship in your name or your company\'s name. Your scholar is not merely a recipient - they are someone building the future alongside you.',
                        'how_it_works' => 'In honour of KazGASA\'s 45th anniversary, we are opening 45 named scholarships. You select a talented student and receive regular progress reports. This is an investment in a specific future leader. Fact: targeted scholarships combined with mentorship significantly improve the chances of a successful career (World Bank, UNESCO).',
                        'what_you_get' => 'A personal success story tied to your name. Recognition within the KazGASA community.',
                    ],
                ],
            ],
            [
                'sort_order' => 40,
                'is_active' => true,
                'icon' => '💳',
                'translations' => [
                    'ru' => [
                        'title' => 'Карта выпускника · Партнёрство',
                        'tags' => 'Пилот · Клиенты · Лояльность',
                        'button_text' => 'Стать партнёром карты',
                        'short' => 'Физическая и цифровая карта, которая объединяет сообщество КазГАСА. Ваш бизнес - среди тех, кому доверяют «свои».',
                        'how_it_works' => 'Карта выпускника открывает доступ к скидкам у партнёров. Ваш бизнес становится эксклюзивным партнёром карты. Люди доверяют брендам, которые уважают их сообщество.',
                        'what_you_get' => 'Новые клиенты из тысяч выпускников КазГАСА. Прямой канал для контакта с платёжеспособной аудиторией.',
                    ],
                    'kk' => [
                        'title' => 'Түлек картасы · Серіктестік',
                        'tags' => 'Пилот · Клиенттер · Адалдық',
                        'button_text' => 'Карта серіктесі болу',
                        'short' => 'ҚазБСҚА қауымдастығын біріктіретін физикалық және цифрлық карта. Сіздің бизнесіңіз – «өз адамдарымыз» сенім артатын серіктестер қатарында.',
                        'how_it_works' => 'Түлек картасы серіктестерден жеңілдік алуға мүмкіндік береді. Сіздің бизнесіңіз картаның эксклюзивті серіктесіне айналады. Адамдар өз қауымдастығын құрметтейтін брендтерге сенім артады.',
                        'what_you_get' => 'ҚазБСҚА-ның мыңдаған түлектері – болашақ клиенттер. Төлем қабілетті аудиториямен тікелей байланыс арнасы.',
                    ],
                    'en' => [
                        'title' => 'Alumni Card · Partnership',
                        'tags' => 'Pilot · Clients · Loyalty',
                        'button_text' => 'Become a Card Partner',
                        'short' => 'A physical and digital card that unites the KazGASA community. Your business - among those trusted by insiders.',
                        'how_it_works' => 'The Alumni Card provides access to partner discounts. Your business becomes an exclusive partner of the card. People trust brands that respect their community.',
                        'what_you_get' => 'New clients from thousands of KazGASA alumni. A direct channel to reach a financially capable and professional audience.',
                    ],
                ],
            ],
        ];

        foreach ($items as $item) {
            $translations = $item['translations'] ?? [];
            unset($item['translations']);

            Project::updateOrCreate(
                ['sort_order' => $item['sort_order']],
                array_merge($item, ['translations' => $translations])
            );
        }
    }
}
