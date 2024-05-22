<?php

enum ApiStatus: string {
    case Success = "success";
    case Failed = "failed";
    case Error = "error";
}

enum BSAlert:int{
case INFO = 0;
case PRIMARY = 1;
case WARNING = 2;
case LIGHT = 3;
case DARK = 4;
case SECONDARY = 5;
case DANGER = 6;
case SUCCESS = 7;
}
