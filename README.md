Данное решение было написано на основе уже имеющейся, ранее написанной мной REST API. 
Для осуществления тестирования я использовал Open Server Panel 6, Postman.
Сначала нужно выполнить команду php artisan migrate, после этого нужно обратиться на адресс https://nevatrip/api/v1/register и передать необходимые данные для регистрации. 
Далее обращаемся на адресс https://nevatrip/api/v1/login с данными зарегестрированого пользователя, получаем Токен. В последующих запросах через Postman к API необходимо передавать Токен.

При отправки данных через Postman по адресу https://nevatrip/api/v1/orders, данные попадают в контроллер, в метод store.
Далее генерируется уникальный Barcode, при помощи метода generateUniqueBarcode() и добавляется к данным. После чего  данные отправляются в метод mockBookingApi(), откуда возращается рандомный ответ.
В случае если возвращается 'barcode already exists', Barcode генерируется снова. В случае ответа 'order successfully booked', Barcode отправляется в метод confirmOrder().

В confirmOrder() генерируется рандомный ответ. В случае ответа 'order successfully aproved' данные записываются в базу данных. В качестве второго ответа comfirmOrder() обращается к другому методу,
mockErrorResponse(), который может вернуть рандомно один из четырех вариантов ответа с ошибками. В таком случае мы получаем ответ 'Order confirmation failed' и название самой ошибки.

Так же более подробно процесс можно отследить благодаря логам (/storage/logs), в них будут записываться все ошибки и т.д.

Для осуществления задания 2 и 3, как оказалось мне понадобиться больше времени. На данный момент разобраться не удалось.
