# Cluedo

Итак, приведу вам очередную небольшую сводку того, что я успел нам сделать за выходные:

1. Исправил недочет с распределением карт - теперь скрипт распределяет карты в зависимости от того, сколько игроков, количество карт для каждого одинаковое (остаточные карты ни к кому не привязываются). Карты для каждого свои (уникальные, без повторений). 
2. Исправил недочет с определением ходов - теперь, когда игрок в комнате, ходы просчитываются сразу из всех входов этой комнаты. 
3. Подправил логику секретных ходов, исправил всякие ошибки, связанные с отображением, активацией и работой кнопок, БД и пр. 
4. Настроил сохранение данных при перезагрузке страницы - теперь после таковой расположение игрока, ботов, статус данной игры и отображение карт сохраняется (ну, и кнопки, само собой). 
5. Сделал предположения - полный функционал для игрока (пользователя): при нажатии на кнопку всплывает окно с выбором трех карт (по типу), выбираем их, после чего в базе данных ищется, кому они принадлежат, и первая же найденная (вернее, только первая найденная, как и в оригинальной игре) карта нам уведомляется с указанием, у кого она есть - в отдельном окошке. Также, в комнату к игроку перемещается автоматически тот игрок (бот), чья фишка соответствует указанному в предположении персонажу. 
6. Сделал обвинения - окошко открывается такое же (внешне), но после выбора трех карт, они теперь проверяются на соответствие решению (через БД) : если игрок угадал неверно, то он становится деактивированным (ход ему больше не дается, его очередь просто пропускается), если же верно - текущая игра заканчивается, предлагается начать новую. 
7. Подключил игровой (основной) файл к веб-странице, которую делала Маша. "Комнаты" теперь пересылают на этот наш основной файл с игрой. Мелочь, но пусть будет.
