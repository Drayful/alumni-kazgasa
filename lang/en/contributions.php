<?php

return [
    'labels' => [
        'what_done' => 'What was done:',
        'note' => 'Note:',
        'photo' => 'Photo',
    ],

    'architecture_card' => [
        'title' => 'Manas Igenovich Kassenov · Yerzhan Abdirakhmanovich Akhmetov',
        'roles' => [
            'Dean of the School of Architecture, associate professor',
            'Associate professor, Department of Urban Planning, School of Architecture',
        ],
        'items' => [
            [
                'title' => 'Named classroom №531',
                'initiators' => 'Initiated by: graduates of groups AS-82–84',
                'description' => 'Classroom №531 was opened on the initiative of alumni who, years later, chose to leave their mark at their alma mater. Today this space bears their name and reminds current students: those who built our country studied here.',
                'what_done' => [
                    'Renovation and refurbishment of the classroom',
                    'Installation of a commemorative plaque',
                    'A comfortable learning environment was created',
                ],
                'note' => null,
            ],
            [
                'title' => 'Named classroom №539',
                'initiators' => 'In memory of: K.Zh. Montakhayev — a graduate who left a bright mark on the university',
                'description' => 'Classroom №539 honours a graduate whose professional and human qualities became an example for many generations. It is a tribute and a symbol of continuity.',
                'what_done' => [
                    'Opening of the named classroom was initiated and organised',
                    'The space was refurbished',
                    'A memorial plaque was installed',
                ],
                'note' => null,
            ],
            [
                'title' => null,
                'pre_initiators_bold' => 'Campus landscaping works',
                'initiators' => 'Initiated by: alumni from different years',
                'description' => 'Alumni organised tree planting on the campus of the International Educational Corporation. Each tree is a living legacy growing with the university and new generations of students.',
                'what_done' => [
                    'Tree planting was organised',
                    'Greening locations were selected',
                ],
                'note' => 'Spruce 6 pcs. (h~1.8 m)',
            ],
        ],
        'photo_keys' => [
            'image7.png', 'image8.png', 'image9.png', 'image10.png', 'image11.png',
        ],
    ],

    'geodesy' => [
        'heading' => '«Geodesy and cartography, cadastre»',
        'cards' => [
            [
                'name' => 'Lutpulla Lepitovich Zhailyov (class of 1993)',
                'subtitle' => null,
                'body' => 'Supported classroom fit-out, donated GPS equipment to the department, and arranges student internships.',
            ],
            [
                'name' => 'Vadim Tsurikov (class of 2007)',
                'subtitle' => 'Director of innovation, SDG Alliance',
                'body' => 'Organised tree planting on the IEC campus together with students and faculty.',
            ],
        ],
    ],

    'design' => [
        'name' => 'Vladislav Alekseevich Tsoi (group PD-15)',
        'subtitle' => 'Industrial designer, founder of «AV1» LLP, Hitone brand',
        'body' => 'Curator of the «Materials library» project.',
        'gallery' => [
            ['file' => 'image3.png', 'caption' => 'Materials library 1'],
            ['file' => 'image4.png', 'caption' => 'Materials library 2'],
            ['file' => 'image1.png', 'caption' => 'Materials library 3'],
            ['file' => 'image2.png', 'caption' => 'Materials library 4'],
        ],
    ],

    'construction' => [
        'cards' => [
            [
                'name' => 'Omar Rakhmankulovich Ospanov',
                'subtitle' => '«CLIMATE EXPERT PARTNERS» LLP',
                'sections' => [
                    ['type' => 'p', 'text' => 'Opening of laboratory №18 «Air conditioning equipment» with support from Daikin.'],
                ],
                'images' => [
                    ['file' => 'image6.png', 'alt' => 'Air conditioning equipment'],
                ],
                'wide' => false,
            ],
            [
                'name' => 'Marat Satybaldiyevich Bakkulov',
                'subtitle' => '«AVZ» LLP',
                'sections' => [
                    ['type' => 'p', 'text' => 'Opening of laboratory №3 «Air ventilation», equipped for 12,000,000 KZT.'],
                ],
                'images' => [
                    ['file' => 'image5.png', 'alt' => 'Air ventilation'],
                ],
                'wide' => false,
            ],
            [
                'name' => 'Yerik Turashovich Besimbaev',
                'subtitle' => "Candidate of Technical Sciences, Associate Professor\nInstitute of Automation and Information Technologies",
                'sections' => [
                    ['type' => 'p', 'text' => 'The university received a special gift from its graduate — a unique small architectural form (MAF) embodying the spirit of engineering thought. The concept is not merely an art object but a visual manifesto of construction science.'],
                    ['type' => 'p', 'text' => 'Three fundamental ideas underpin the MAF:'],
                    ['type' => 'ul', 'items' => [
                        ['k' => 'Science:', 'v' => 'the orbit crowning the composition symbolises the continuous pursuit of knowledge and the global scale of research.'],
                        ['k' => 'Engineering:', 'v' => 'stylised forms of the building, foundation and pile recall the inseparable link in the «soil — foundation — structure» system.'],
                        ['k' => 'Resilience:', 'v' => 'the granite slab at the base guarantees reliability of the whole structure.'],
                    ]],
                ],
                'images' => [
                    ['file' => 'image12.png', 'alt' => 'MAF — gift from graduate Y.T. Besimbaev'],
                ],
                'wide' => true,
            ],
        ],
    ],
];
