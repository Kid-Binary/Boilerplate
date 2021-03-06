<?php
// AppBundle/DataFixtures/ORM/LoadSupplier.php
namespace AppBundle\DataFixtures\ORM;

use DateTime;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Supplier\Supplier;

class LoadSupplier extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager->persist
        (
            $supplier_vitmark = (new Supplier)
                ->setName("Вітмарк-Україна")
                ->setNameLegal("СП \"ВІТМАРК - УКРАЇНА\"")
                ->setDescription(
                    "<p>Компанія Вітмарк-Україна посідає провідні позиції на українському ринку соків та напоїв, а також на ринку дитячого харчування у сегменті фруктово-овочевих соків та пюре. За підсумками 2014-го року частка компанії на ринку склала близько 28%.</p>"
                    .PHP_EOL.
                    "<p>У портфелі компанії широкий асортимент продукції – соки Jaffa, вода Aquarte, сім`я брендів від Одеського заводу дитячого харчування – Наш сік, соки прямого віджиму Прямосік, смузі Просто Фрукти, дитяче харчування Чудо-чадо. Лідерство компанії обумовлено високою якістю продукції, натуральністю та доступністю завдяки власній переробці українських фруктів та овочей, а також співробітництву  з провідними світовими постачальниками. Продукція компанії експортується у більш ніж 20 країн світу. Головний офіс компанії знаходиться в Одесі.</p>"
                    .PHP_EOL.
                    "<p>За 20-річну історію компанії Вітмарк-Україна її продукція отримала визнання багатьох авторитетних міжнародних конкурсів та рейтингів популярності брендів, але головне – це визнання споживачів.</p>"
                    .PHP_EOL.
                    "<p>Протягом останніх 15-ти років, продукція Вітмарк-Україна вдало експортувалась у країни СНД, Європи, а також у США, Канаду, Ізраїль. У 2013 році компанія пройшла сертифікацію на відповідність вимогам міжнародних стандартів менеджмента якості ISO 9001:2008 і системи менеджмента безпеки харчової продукції ISO 22000:2005.</p>"
                )
                ->setDescriptionShort("Компанія Вітмарк-Україна посідає провідні позиції на українському ринку соків та напоїв, а також на ринку дитячого харчування.")
                ->setLogoName("vitmark.png")
                ->setUpdatedAt(new DateTime)
        );

        // ---

        $manager->persist
        (
            $supplier_ekonia = (new Supplier)
                ->setName("Еконія")
                ->setNameLegal("ТОВ ПІІ \"ЕКОНІЯ\"")
                ->setDescription(
                    "<p>Історія компанії починається в 2001 році, коли було запущене перше місцеве виробництво спеціалізований води для дітей від 1 місяця до 6 років в Україні.</p>"
                    .PHP_EOL.
                    "<p>При цьому компанія, заснувала новий сегмент на ринку України - спеціалізована вода для дітей, яка існує на межі сегментів питної води і дитячого харчування. Від тоді вже майже 12 років компанія є абсолютним лідером на ринку води для новонароджених в Україні (MS-80о об'єму продажів, Нильсен Україна).</p>"
                    .PHP_EOL.
                    "<p>З моменту створення і розвитку культура споживання води для немовлят \"Экония\" стимулює зростання продажів загального сегменту води в Україні. Починаючи з 2014 року ми запустили проект пюре і соків для дітей. \"Экония\" займає 9 місце в TOP - 15 виробників в Україні.</p>"
                )
                ->setDescriptionShort("Історія компанії починається в 2001 році, коли було запущене перше місцеве виробництво спеціалізованиї води для дітей від 1 місяця до 6 років в Україні.")
                ->setLogoName("ekoniya.png")
        );

        // ---

        $manager->persist
        (
            $supplier_biscvit = (new Supplier)
                ->setName("Бісквіт-шоколад")
                ->setNameLegal("ПАТ \"ХАРКІВСЬКА БІСКВІТНА ФАБРИКА\", ТМ \"БІСКІВТ-ШОКОЛАД\", ПАТ \"КОНДИТЕРСЬКА ФАБРИКА \"ХАРКІВ’ЯНКА\"")
                ->setDescription(
                    "<p>Початком промислового виробництва кондитерських виробів в місті Харкові вважається 1896 рік, коли було засновано кондитерську фабрику Жоржа Бормана - видатного кондитера, який отримав звання \"Постачальник Імператорського двору\" та чимало міжнародних нагород. Пізніше, 1935 року, було створено ще одне велике кондитерське підприємство - \"Харківську Бісквітну Фабрику\". З 2001 року обидва підприємства почали випускати свою продукцію під спільною торговельною маркою - \"Бісквіт-Шоколад\", а в серпні 2004 року об'єдналися в однойменну корпорацію.</p>"
                    .PHP_EOL.
                    "<p>До асортименту борошняних кондитерських виробів, що виробляє корпорація, входять печиво (цукрове, здобне, затяжне, вівсяне), крекер, галети, вафлі, вафельні трубочки, бісквіти, рулети, торти вафельні та шоколадно-вафельні, пироги пісочні, вафельні десерти, батончики шоколадно-горіхові. Асортимент цукрової групи складається з карамелі, глазурованих та неглазурованих цукерок, шоколаду, тортів, зефіру, ірису, мармеладу.</p>"
                )
                ->setDescriptionShort("Фабрика Жоржа Бормана - видатного кондитера, була засновано у 1896 році, коли почалось промислове виробництво в місті Харків.")
                ->setLogoName("biskvit-shokolad.png")
        );

        // ---

        $manager->persist
        (
            $supplier_sladkiy = (new Supplier)
                ->setName("Солодкий світ")
                ->setNameLegal("ТОВ \"КОНДИТЕРСЬКА ФАБРИКА \"СОЛОДКИЙ СВІТ\"")
                ->setDescription(
                    "<p>Кондитерська фабрика «СОЛОДКИЙ СВІТ» - великий український виробник, лідер у ніші виготовлення натуральних солодощів.</p>"
                    .PHP_EOL.
                    "<p> «Світ натуральних солодощів» - це не просто рекламний слоган, але та місія, яка полягає в тому, щоб створювати здорові, корисні, смачні солодощі для дітей та дорослих.У виробництві використовується бельгійський шоколад і натуральна високоякісна сировина, без замінників цукру, лауриновых жирів, і шкідливих Е компонентів. Значну частку продукції складають ексклюзивні вироби з великою часткою ручної праці.</p>"
                    .PHP_EOL.
                    "<p>Компанія випускає близько ста видів продукції. Солодощі компанії «СОЛОДКИЙ СВІТ» продаються в Україні, Латвії, Польщі, Болгарії, Німеччини.</p>"
                )
                ->setDescriptionShort("Кондитерська фабрика \"СОЛОДКИЙ СВІТ\" - великий український виробник, лідер у ніші виготовлення натуральних солодощів.")
                ->setLogoName("sladkiy-myr.png")
        );

        // ---

        $manager->persist
        (
            $supplier_tekmar = (new Supplier)
                ->setName("Текмар Словенско")
                ->setNameLegal("ТЕКМАР СЛОВЕНСКО – TEKMAR SLOVENSKO, s.r.o.")
                ->setDescription(
                    "<p>Компанія Tekmar виробляє унікальні батончики мюслі для дієтичного харчування та активного способу життя, дотримуючись специфічних особливостей і харчових звичок клієнтів. \"Ми прагнемо до того, щоб наші продукти мали багатий зміст і смак. Ми приділяємо велику увагу технологічним і людському ресурсам.\"</p>"
                )
                ->setDescriptionShort("Компанія Tekmar виробляє унікальні батончики мюслі для дієтичного харчування та активного способу життя.")
                ->setLogoName("tekmar.png")
        );

        // ---

        $manager->persist
        (
            $supplier_ramonka = (new Supplier)
                ->setName("Рамонка")
                ->setNameLegal("ТОВ \"АРСЕНАЛ-ПАК\", ТМ \"РАМОНКА\"")
                ->setDescription(
                    "<p>Компанія «Арсенал - Пак» працює на ринку України з 2003 року як український виробник кондитерських виробів і продуктів снекової групи.</p>"
                    .PHP_EOL.
                    "<p>Асортимент нашої компанії включає більше 50 найменувань традиційних солодощів - козинаки, ірис, драже, мармелад, рахат-лукум та інші вироби. У продукції ми успішно об'єднали сучасні технології з рецептами, заснованими на старих добрих традиціях.</p>"
                    .PHP_EOL.
                    "<p>Кондитерські вироби компанії «Арсенал - Пак» доступні кожному: і дорослому, і дитині. Наша компанія завжди рада піднести Вам можливість поділитися задоволенням і гармонією смаку, втіленими в солодощах.</p>"
                    .PHP_EOL.
                    "<p>До того ж ТОВ «Арсенал - Пак» випускає високоякісну продукцію. Про що говорить присудження звання лауреата регіонального етапу всеукраїнського конкурсу якості «100 кращих товарів України» у 2008 р.</p>"
                    .PHP_EOL.
                    "<p>ТОВ «Арсенал - Пак» властива позитивна динаміка зростання, постійне оновлення і розширення асортименту продукції, модернізація та підвищення ефективності виробництва.</p>"
                )
                ->setDescriptionShort("Асортимент нашої компанії включає більше 50 найменувань традиційних солодощів - козинаки, ірис, драже, мармелад, рахат-лукум та інші вироби.")
                ->setLogoName("ramonka.png")
        );

        // ---

        $manager->persist
        (
            $supplier_sergio = (new Supplier)
                ->setName("Серджіо")
                ->setNameLegal("ТОВ \"СЕРДЖІО\"")
                ->setDescription(
                    "<p>Компанія SERGIO (товариство з обмеженою відповідальністю) була створена в 2010 році.</p>"
                    .PHP_EOL.
                    "<p>Виробництво тільки високоякісної натуральної продукції за технологією, яка дозволяє зберегти всі мінеральні речовини без додавання консервантів, жирів і цукру, для того, щоб захистити, оздоровити і зробити кожен день в житті наших дітей повним радості і фарб!</p>"
                    .PHP_EOL.
                    "<p>Компанія \"Серджио\" робить якісні сухофрукти TM SERGIО.Мета компанії - виробництво тільки високоякісної натуральної продукції за технологією, яка дозволяє зберегти усі вітаміни і мінеральні речовини без додавання консервантів, жирів і цукру. Великий асортимент вироблюваної продукції включає фасовані сушені ягоди, фрукти, овочі для кінцевого споживача, а так само масова сушена продукція для підприємств громадського харчування і фармацевтичних компаній. Для виробництва на підприємстві використовується сировиннабаза з екологічно чистих районів України.</p>"
                )
                ->setDescriptionShort("Компанія \"Серджио\" робить якісні сухофрукти TM SERGIО. Мета компанії - виробництво тільки високоякісної натуральної продукції для дітей.")
                ->setLogoName("sergio.png")
        );

        // ---

        $manager->persist
        (
            $supplier_kvartet = (new Supplier)
                ->setName("Квартет")
                ->setNameLegal("ТОВ \"Кондитерськамайстерня \"Квартет\"")
                ->setDescription(
                    "<p>ТМ \"Джинджер\" є власністю компанії ТОВ \"Кондитерська майстерня \"Квартет\", яка почала свою діяльність в 2009г.</p>"
                    .PHP_EOL.
                    "<p>На початку компанія займалася виключно виготовленнямхудожніх тортів, але потім, в результаті експериментів,сформувався окремий напрям - виготовлення авторських імбирних пряників під власним брендом.</p>"
                    .PHP_EOL.
                    "<p>Уся продукція ТМ \"Джинджер\" має гігієнічні висновки необхідні для роздрібної торгілі.</p>"
                    .PHP_EOL.
                    "<p>Усіх пряників оформляються майстрами кондитерами вручну. Тому усі вони не схожі один на іншій, немає абсолютно однакових пряників.</p>"
                    .PHP_EOL.
                    "<p>Усі складові пряника натуральні: мед, житнє і пшеничнеборошно, кориця, гвоздика, імбир, кардамон, бад'ян, вершкове масло. Тому ми з повною упевненістю можемо рекомендувати свої пряники навіть дітям дитячого віку.</p>"
                )
                ->setDescriptionShort("Компанія займалася виключно виготовленням художніх тортів, але потім, сформувався окремий напрям - виготовлення авторських імбирних пряників.")
                ->setLogoName("kvartet.png")
        );

        // ---

        $manager->flush();

        $this->addReference('supplier_vitmark', $supplier_vitmark);
        $this->addReference('supplier_ekonia', $supplier_ekonia);
        $this->addReference('supplier_biscvit', $supplier_biscvit);
        $this->addReference('supplier_sladkiy', $supplier_sladkiy);
        $this->addReference('supplier_tekmar', $supplier_tekmar);
        $this->addReference('supplier_ramonka', $supplier_ramonka);
        $this->addReference('supplier_sergio', $supplier_sergio);
        $this->addReference('supplier_kvartet', $supplier_kvartet);
    }

    public function getOrder()
    {
        return 8;
    }
}