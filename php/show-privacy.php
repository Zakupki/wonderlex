﻿<?php

$privacy = $_GET[ 'privacy' ];

if( $privacy == 1 ){
    $json_data = '{ "html": "
    <div class=\"privasy\">
        <h2 class=\"privasy__title\">правила конфиденциальности</h2>
        <div class=\"scroll scroll-privacy\">
            <div>
                <div class=\"privasy__layout\">
                    <p class=\"privasy__txt\">Бюджет на размещение основан на опыте. В общем, ребрендинг позитивно специфицирует
                        конструктивный опрос, оптимизируя бюджеты. Соц-дем характеристика аудитории, отбрасывая подробности,
                        стабилизирует эмпирический рекламный бриф, учитывая результат предыдущих медиа-кампаний. Таргетирование
                        конструктивно.</p>
                    <p class=\"privasy__txt\">Опрос, анализируя результаты рекламной кампании, спонтанно переворачивает побочный PR-эффект, размещаясь
                        во всех медиа. Правда, специалисты отмечают, что продукт раскручивает сублимированный план размещения,
                        учитывая современные тенденции. Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает
                        конвергентный инвестиционный продукт, </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                </div>
            </div>
        </div>
        <a href=\"#\" class=\"pdf-btn\">Скачать PDF</a>
    </div>
    " }';
} else {
    $json_data = '{ "html": "
<div class=\"privasy\">
        <h2 class=\"privasy__title privasy__title_empty\">Content</h2>
        <div class=\"scroll scroll-privacy\">
            <div>
                <div class=\"privasy__layout\">
                    <p class=\"privasy__txt\">Бюджет на размещение основан на опыте. В общем, ребрендинг позитивно специфицирует
                        конструктивный опрос, оптимизируя бюджеты. Соц-дем характеристика аудитории, отбрасывая подробности,
                        стабилизирует эмпирический рекламный бриф, учитывая результат предыдущих медиа-кампаний. Таргетирование
                        конструктивно.</p>
                    <p class=\"privasy__txt\">Опрос, анализируя результаты рекламной кампании, спонтанно переворачивает побочный PR-эффект, размещаясь
                        во всех медиа. Правда, специалисты отмечают, что продукт раскручивает сублимированный план размещения,
                        учитывая современные тенденции. Пак-шот нетривиален. Рекламный клаттер пока плохо восстанавливает
                        конвергентный инвестиционный продукт, </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                    <h2 class=\"privasy__sub-title\">пункт 1.1.</h2>
                    <p class=\"privasy__txt\">Рекламный клаттер абстрактен. Изменение глобальной стратегии, как принято считать,
                        амбивалентно. Такое понимание ситуации восходит к Эл Райс, при этом перераспределение бюджета изящно
                        синхронизирует комплексный фактор коммуникации, используя опыт предыдущих кампаний. Такое понимание
                        ситуации восходит к Эл Райс, при этом социальный статус спорадически программирует креативный целевой
                        сегмент рынка, полагаясь на инсайдерскую информацию. Личность топ менеджера упорядочивает стратегический
                        медиамикс, осознавая социальную ответственность бизнеса.</p>
                    <p class=\"privasy__txt\">Повышение жизненных стандартов, как следует из вышесказанного, недостижимо.
                        Несмотря на сложности, маркетинговая </p>
                </div>
            </div>
        </div>
        </div>
    " }';
}



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
?>