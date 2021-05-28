<?php
class  Router
{
    private static $routes = [];
    private static $found = false;

    public static function add($uri, closure $custom_function)
    {
        $uri = ltrim($uri, '/'); //убрать левый слеш, т.к. QUERY_STRING не содержит его, но он добавлен в маршруте для красоты
        $uri = str_replace('/', '\/', $uri); // экранировать прямые слеши, чтобы они не интерпретировались как служебные символы
        $uri = '/^' . $uri . '$/'; // поместить все выражение между маркерами начала и конца регулоярного выражения
        self::$routes[$uri] = $custom_function; // именованый ключ массива $routes[$uri] будет содержать hph код анонимной функции
    }

    public static function start()
    {
        foreach (self::$routes as $uri => $custom_function) // вытаскиваем из массива $key => $value
        {
            if (preg_match($uri, $_SERVER["QUERY_STRING"], $params))
                // проверяет регулярное выражение в QUERY_STRING и ищет по шаблону в $uri
                // в скобках регулярного выражения данные заносятся в $params (если они там есть)
            {
                // нулевой элемент массива $params содержит QUERY_STRING полностью и не используется
                array_shift($params); // удаляем нулевой элемент

                // вызывает функцию обратного вызова или замыкание + параметры из регулярного выражения,
                // которые можно использовать в коде своей функции
                call_user_func_array($custom_function, $params);
                self::$found = true;
            }
        }
        if(!self::$found) self::notFound();
    }

    private static function notFound(): void
    {
        http_response_code(404);
        header("Location: 404.php");
        exit();
    }
}