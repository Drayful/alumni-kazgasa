# Таблицы iPortal (БД moodle, подключение `iportal`)

Используются для проверки выпускников по ИИН и году выпуска и подтягивания данных (группа, форма обучения, факультет, ОП, ГОП).

---

## portal_persons

Справочник персоналий.

| Поле | Тип | Описание |
|------|-----|----------|
| id | bigint PK | |
| barcode | varchar(30) | |
| lastname, firstname, middlename | varchar(100) | |
| sortname | varchar(100) | |
| lastname_rus, firstname_rus, middlename_rus | varchar(100) | |
| lastname_eng, firstname_eng, middlename_eng | varchar(100) | |
| lastname_kaz, firstname_kaz, middlename_kaz | varchar(100) | |
| preferredname | varchar(100) | |
| mdluser | bigint | |
| status | int | 1-обучается, 2-отчислен, 3-академ, 4-абитуриент, 5-с другого ВУЗа, 6-окончил, 7-мусор, 8-для диплома; для ППС: 1 работает, 0 уволен |
| repeat_course | tinyint(1) | |
| enter_year | bigint | |
| study_year | int | |
| study_rup | int | |
| edu_op | int | ОП (образовательная программа) |
| study_kurs | int | |
| study_term | int | Срок обучения |
| study_lang | int | |
| study_form | int | Форма обучения |
| study_level | int | |
| study_group | int | Группа |
| study_group_eng, study_group_kaz, study_group_rus | int | |
| user_type | int | 1-студент, 2-ППС, 3-сотрудник, ... |
| dop_user_type | int | |
| payment_type | int | 1-платный 2-грант |
| department_id | int | Факультет/подразделение |
| contract_number | varchar(255) | |
| position | int | |
| docs_position | int | |
| docs_department | int | |
| abiturient_barcode | int | UNIQUE |
| ... | | см. полный CREATE TABLE в задаче |

---

## portal_persons_d

Связь персоны с документом (ИИН). Используется для поиска по ИИН в приказах.

| Поле | Описание |
|------|----------|
| student_id | → portal_persons.id |
| doc_iin | ИИН |

---

## GRADUATES

Выпускники. Связь по ИИН (`iinPlt`) и году выпуска (`finishOrderDate`).

| Поле | Тип | Описание |
|------|-----|----------|
| graduateId | int PK | Может совпадать с portal_persons.id |
| typeCode | varchar(100) | |
| universityId | int | |
| firstName, lastName, patronymic | varchar(100) | |
| birthDate | varchar(100) | |
| iinPlt | varchar(100) | ИИН |
| finishOrderDate | date | Дата приказа о выпуске |
| startOrderNumber, finishOrderNumber | varchar(100) | |
| professionId | int | Специальность |
| studyFormId | int | Форма обучения |
| studyLanguageId | int | |
| studentId | varchar(100) | |
| ... | | см. полный CREATE TABLE в задаче |

---

## portal_orders

Приказы. Год из `date` или `completed_at`.

| Поле | Тип | Описание |
|------|-----|----------|
| id | int PK | |
| number | varchar(254) | |
| study_year | int | |
| date | date | Дата приказа |
| body_kz, body_ru, body_en | text | |
| order_type_id | int | |
| completed_at | datetime | Дата завершения |
| ... | | |

---

## portal_order_sections

Секции приказа (стипендии, переводы и т.д.).

| Поле | Тип | Описание |
|------|-----|----------|
| id | int PK | |
| order_id | int | Ссылка на portal_orders |
| body_kz, body_ru, body_en | text | |
| scholarship_* | | |
| ... | | |

---

## portal_order_section_persons

Персоны в секциях приказа. Связь person_id → portal_persons.id. Содержит группу, ОП, ГОП на момент приказа.

| Поле | Тип | Описание |
|------|-----|----------|
| id | int PK | |
| section_id | int | |
| person_id | int | → portal_persons.id |
| edu_op | int | ОП |
| edu_program | int | ГОП |
| study_level | int | |
| study_lang | int | |
| study_form | int | Форма обучения |
| study_group | int | Группа |
| study_kurs | int | |
| ... | | |

---

## Логика при регистрации

1. Сравнивать год выпуска (выбор пользователя) с:
   - `GRADUATES.finishOrderDate` (год) и `GRADUATES.iinPlt` = ИИН
   - либо приказы `portal_orders`: год из `date`/`completed_at` и персоны по ИИН (если есть связь)
2. При совпадении: подтянуть из portal_persons и/или portal_order_section_persons: группа, форма обучения, факультет (department_id), ОП (edu_op), ГОП (edu_program).
3. Если совпадения нет — оставить поля пустыми, разрешить редактирование профиля.

---

## Порядок поиска выпускника в iPortal

1. **Сначала** — по приказам выпуска (portal_persons + portal_persons_d + portal_orders, order_type_id = 34).
2. **Если не найдено** — по таблице GRADUATES (iinPlt + год finishOrderDate).

---

## SQL 1: portal_persons / приказы (используется первым)

```sql
SELECT
    pp.*,
    pers.edu_op   AS pers_edu_op,
    pers.edu_program,
    pers.study_group,
    pers.study_form
FROM portal_persons pp
LEFT JOIN portal_persons_d ppd ON ppd.student_id = pp.id
LEFT JOIN portal_order_section_persons pers ON pers.person_id = pp.id
LEFT JOIN portal_order_sections sec ON sec.id = pers.section_id
LEFT JOIN portal_orders po ON po.id = sec.order_id
LEFT JOIN portal_agroups pa ON pa.id = pp.study_group
LEFT JOIN portal_sp_edu_op op ON op.id = pp.edu_op
LEFT JOIN portal_sp_group_edu_op gop ON gop.id = op.group_op_id
LEFT JOIN portal_sp_faculties fac ON fac.id = op.faculty_id
LEFT JOIN portal_sp_edu_form form ON form.id = pp.study_form
LEFT JOIN portal_sp_edu_level level ON level.id = pp.study_level
WHERE po.order_type_id = 34
  AND ppd.doc_iin = :iin
  AND YEAR(po.date) = :graduation_year
LIMIT 1;
```

Дополнительно выбирать названия: `pa.name` (группа), `op.name_ru` (ОП), `gop.name_ru` (ГОП), `fac.name_ru` (факультет), `form.name_ru` (форма обучения), `level.name_ru` (степень/уровень).

- **:iin** — ИИН из формы (строка).
- **:graduation_year** — год выпуска.
- **portal_persons_d** — связь персоны с ИИН (поле `doc_iin`), `student_id` = `portal_persons.id`.
- **order_type_id = 34** — приказы выпуска.
- **portal_agroups** (pa) — справочник групп, `pa.id = pp.study_group`.
- **portal_sp_edu_op** (op) — справочник ОП, `op.id = pp.edu_op`.
- **portal_sp_group_edu_op** (gop) — справочник ГОП, `gop.id = op.group_op_id`.

---

## SQL 2: GRADUATES (если по приказам не нашли)

```sql
SELECT *
FROM GRADUATES
WHERE iinPlt = :iin
  AND YEAR(finishOrderDate) = :graduation_year
LIMIT 1;
```

Возможные причины «не нашёлся»: регистр имени таблицы, формат ИИН в БД, NULL/другой формат даты, ошибка подключения к iPortal (см. `storage/logs/laravel.log`).
