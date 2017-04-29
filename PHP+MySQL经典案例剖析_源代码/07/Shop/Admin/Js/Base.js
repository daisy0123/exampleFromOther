/**
 * 功能：取得对象组
 * 该函数可以说是document.getElementById(id)的简化调用
 */
function $()
{
    var elements = new Array();
    for (var i = 0; i < arguments.length; i++)
    {
        var element = arguments[i];
        if (typeof element == 'string')
        element = document.getElementById(element);
        if (arguments.length == 1)
        return element;
        elements.push(element);
    }
    return elements;
}
/**
 * 为兼容旧版本的浏览器增加 Array 的 push 方法。
 */
if (!Array.prototype.push)
{
    Array.prototype.push = function()
    {
        var startLength = this.length;
        for (var i = 0; i < arguments.length; i++)
        this[startLength + i] = arguments[i];
        return this.length;
    }
}
/**
 * 定义javascript原形trim
 * 功能是去掉前后的空格
 */
String.prototype.trim = function()
{
    return this.replace(/(^\s*)|(\s*$)/g, "");
}
/**
 * 定义javascript原形len
 * 功能是取得字符串的长度（一个双字节字符长度计2，ASCII字符计1）
 */

String.prototype.len = function(){
	return this.replace(/[^\x00-\xff]/g,"aa").length;
}
