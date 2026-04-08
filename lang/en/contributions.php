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
            'Dean of the School of Architecture, KazGASA, Associate Professor',
            'Associate Professor, Department of Civil Engineering, School of Architecture',
        ],
        'items' => [
            [
                'title' => 'Named Classroom No. 531',
                'initiators' => 'Initiators: graduates of groups АС-82–84',
                'description' => 'Classroom No. 531 was opened at the initiative of alumni who, years later, decided to leave their mark on their Alma Mater. Today this space bears their name and serves as a reminder to current students: those who built our country once studied here.',
                'what_done' => [
                    'Repair and renovation of the classroom was carried out',
                    'A memorial plaque was installed',
                    'A comfortable learning space was created',
                ],
                'note' => null,
            ],
            [
                'title' => 'Named Classroom No. 539',
                'initiators' => 'In memory of K.Zh. Montakhayev — a graduate who left a bright mark on the life of the university',
                'description' => 'Classroom No. 539 was opened in memory of a graduate whose professional and personal qualities became an example for many generations. This place is a tribute of respect and a symbol of the continuity of traditions.',
                'what_done' => [
                    'The opening of the named classroom was initiated and organised',
                    'The space was renovated',
                    'A commemorative plaque was installed',
                ],
                'note' => null,
            ],
            [
                'title' => null,
                'pre_initiators_bold' => 'Landscaping works were carried out on the grounds',
                'initiators' => 'Initiators: alumni of various graduation years',
                'description' => 'Alumni organised the planting of trees on the grounds of the International Educational Corporation. Each tree is a living mark that will grow alongside the university and new generations of students.',
                'what_done' => [
                    'Tree planting was organised',
                    'Sites for landscaping were selected',
                ],
                'note' => 'Note: Spruce trees — 6 pcs. (height 1.8 m)',
            ],
        ],
        'photo_keys' => [
            'image7.png', 'image8.png', 'image9.png', 'image10.png', 'image11.png',
        ],
    ],

    'geodesy' => [
        'heading' => '"Geodesy and Cartography, Cadastre"',
        'cards' => [
            [
                'name' => 'Lutpulla Lepitovich Zhalilov (Class of 1993)',
                'subtitle' => null,
                'body' => 'Assisted with the fit-out of the classroom, donated GPS equipment to the department, and provides industrial placement opportunities for students.',
            ],
            [
                'name' => 'Vadim Tsurikov (Class of 2007)',
                'subtitle' => 'Director of Innovation, SDG Alliance',
                'body' => 'Organised the planting of trees on the IEC grounds together with students and faculty.',
            ],
        ],
    ],

    'design' => [
        'name' => 'Vladislav Alekseyevich Tsoy (Group PD-15)',
        'subtitle' => 'Industrial designer, founder of AV1 LLP, Hitone brand',
        'body' => 'Curator of the "Materials Library" project.',
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
                'subtitle' => 'Climate Expert Partners LLP',
                'sections' => [
                    ['type' => 'p', 'text' => 'Opening of Laboratory No. 18 "Air Conditioning Equipment" with the support of Daikin.'],
                ],
                'images' => [
                    ['file' => 'image6.png', 'alt' => 'Air conditioning equipment'],
                ],
                'wide' => false,
            ],
            [
                'name' => 'Marat Satybaldiyevich Bakkulov',
                'subtitle' => 'AVZ LLP',
                'sections' => [
                    ['type' => 'p', 'text' => 'Opening of Laboratory No. 3 "Air Ventilation", equipped with machinery worth 12,000,000 tenge.'],
                ],
                'images' => [
                    ['file' => 'image5.png', 'alt' => 'Air ventilation'],
                ],
                'wide' => false,
            ],
            [
                'name' => 'Yerik Turashovich Besimbayev',
                'subtitle' => 'Candidate of Technical Sciences, Associate Professor, Institute of Automation and Information Technologies',
                'sections' => [
                    ['type' => 'p', 'text' => 'Our university received a special gift from one of its graduates — a unique small architectural form (SAF) that embodies the spirit of engineering thought. This concept is not merely an art object, but a visual manifesto of construction science.'],
                    ['type' => 'p', 'text' => 'The SAF is built upon three fundamental ideas:'],
                    ['type' => 'ul', 'items' => [
                        ['k' => 'Science:', 'v' => 'the orbit crowning the composition symbolises the continuous pursuit of knowledge and the global reach of scientific research.'],
                        ['k' => 'Engineering:', 'v' => 'the stylised forms of the building, foundation and piles serve as a reminder of the inseparable connection between the elements of the "soil — foundation — structure" system.'],
                        ['k' => 'Sustainability:', 'v' => 'the granite slab at the base serves as the guarantor of the reliability of the entire structure.'],
                    ]],
                ],
                'images' => [
                    ['file' => 'image12.png', 'alt' => 'The SAF is a gift from graduate Ye. T. Besimbayev'],
                ],
                'wide' => true,
            ],
        ],
    ],
];
