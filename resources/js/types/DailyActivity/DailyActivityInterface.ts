import { MetaInterface } from "../MetaInterface";
import { DailyActivityData } from "./DailyActivityData";

export interface DailyActivityInterface{
    data:DailyActivityData[];
    meta:MetaInterface;
}
