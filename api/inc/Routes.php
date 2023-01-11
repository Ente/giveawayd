<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/inc/giveawayd.php";

use Discord\Http\Exceptions\NotFoundException;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\SimpleRouter\Handlers\EventHandler;
use Pecee\SimpleRouter\Route\IGroupRoute;
use Pecee\SimpleRouter\Route\ILoadableRoute;
use Pecee\SimpleRouter\Event\EventArgument;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use GiveawayD\GiveawayD as GwD;

$gw = new Gwd;

$basepath = "/";
$eventHandler = new EventHandler();
$eventHandler->register(EventHandler::EVENT_ADD_ROUTE, function(EventArgument $event) use ($basepath){
    $route = $event->route;
    if(!$event->isSubRoute){
        return;
    }

    switch(true){
        case $route instanceof ILoadableRoute:
            $route->prependUrl($basepath);
            break;
        case $route instanceof IGroupRoute:
            $route->prependPrefix($basepath);
            break;
    }
});

Router::addEventHandler($eventHandler);

Router::get("/error", function(){
    Gwd::createView("404.html");
});

Router::error(function(Request $request, \Exception $exception){
    if($exception instanceof NotFoundException){
        Router::response()->redirect("/error");
    }
});
#Routes

Router::get("/", function(){
    Gwd::createView("index");
    echo "redirect 1";
});

Router::get("/g/{id}", function($id){
    Router::response()->redirect("/?id={$id}");
});

Router::get("/assets/{r}", function($r){
    header("Location: /assets/{$r}");
});

Router::get("/api/v1/{action?}", function($action){
    Router::response()->redirect("/api/v1/{$action}");
});
Router::get("/api/{action?}", function($action){
    Router::response()->redirect("/api/v1/{$action}");
});
Router::post("/api/v1/{action?}", function($action){
    Router::response()->redirect("/api/v1/{$action}");
});
Router::post("/api/{action?}", function($action){
    Router::response()->redirect("/api/v1/{$action}");
});

Router::get("/api/v1/login.php", function(){
    header("Location: /api/login.php");
})
?>
