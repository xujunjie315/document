# phpquery

## 1.下载phpquery

* [下载](http://www.thinkphp.cn/donate/download/id/665.html)

## 2.引入phpquery

```bash
    header("Content-Type: text/html;charset=utf-8");
    require('phpQuery/phpQuery.php');
    //读取文件内容
    $eg1=phpQuery::newDocumentFile("test.htm");
    //获取网页内容
    $eg2=phpQuery::newDocumentFile("http://www.baidu.com");
    //读取html内容
    $html="<div>
        <ul>
            <li>第一行</li>
            <li>第二行</li>
        </ul>
       </div";
    $eg3=phpQuery::newDocument($html);
```

## 3.选择器

### 基本选择器

* #id 根据给定的ID属性匹配单个元素。
* element 根据给定的名称匹配所有符合的元素。
* .class 根据给定的class匹配所有的元素。
* *选择所有元素。
* selector1, selector2, selectorN 根据所有制定的选择器匹配结合结果 选择结果是取并集

### 层次选择器

* ancestor descendant 匹配由先祖指定的元素的后代指定的所有后代元素。
* parent > child 匹配由父元素指定的子元素指定的所有子元素。
* prev + next 根据指定的”next”和指定的”prev”匹配所有的下一个元素。
* prev ~ siblings 匹配根据”prev” 元素的 所有相邻元素。

## 4.过滤器

### 基础过滤

* :first 匹配第一个被选择的元素。
* :last 匹配最后一个被选择的元素。
* :not(selector) 匹配所有不是被选择的元素。
* :even 匹配所有被选择的偶数元素，0索引。
* :odd 匹配所有被选择的奇数元素，0索引。
* :eq(index) 匹配等同于给定的索引的元素。
* :gt(index) 匹配大于给定的索引的元素。
* :lt(index) 匹配小于给定的索引的元素。
* :header 匹配所有header元素，如h1,h2,h3等。
* :animated 匹配正在进行动画效果的元素。

### 内容过滤

* :contains(text) 匹配包含指定文本的元素。
* :empty 匹配所有无子节点的元素（包括文本节点）。
* :has(selector) 匹配至少包含一个对于给定选择器的元素。
* :parent 匹配所有父元素 - 拥有子元素的，包括文本。

### 属性过滤

* [attribute] 匹配给定属性的元素。
* [attribute=value] 匹配给定属性等于确定值的元素。
* [attribute!=value] 匹配给定属性不等于确定值的元素。
* [attribute^=value] 匹配给定属性是确定值开始的元素。
* [attribute$=value] 匹配给定属性是确定值结尾的元素。
* [attribute*=value] 匹配给定属性包含确定值的元素。
* [selector1selector2selectorN] 匹配给定属性并且包含确定值的元素。

### 子元素过滤

* :nth-child(index/even/odd/equation) 匹配所有是父元素的第n个的子元素，或者是父元素的偶数或者奇数子元素。
* :first-child 匹配所有是父元素的第一个的子元素。
* :last-child 匹配所有是父元素的最后一个的子元素。
* :only-child 匹配所有是父元素唯一子元素的子元素。

### 基于表单

* :input 匹配input, textarea, select和button元素。
* :text 匹配所有类型为text的input元素。
* :password 匹配所有类型为password的input元素。
* :radio 匹配所有类型为radio的input元素。
* :checkbox 匹配所有类型为checkbox的input元素。
* :submit 匹配所有类型为submit的input元素。
* :image 匹配所有类型为image的input元素。
* :reset 匹配所有类型为reset的input元素。
* :button 匹配所有类型为button的input元素和button元素。
* :file 匹配所有类型为file的input元素。
* :hidden 匹配所有类型为hidden的input元素或者其他hidden元素。

### 表单过滤

* :enabled 匹配所有可用元素。
* :disabled 匹配所有不可用元素。
* :checked 匹配所有被勾选的元素。
* :selected 匹配所有被选择的元素。

## 5.内容获取

### attr属性获取

* attr($name) 访问第一个给名称的元素的属性。这个方法可以很轻易地取得第一个匹配到的元素的属性值。如果这个元素没有对应名称的属性则返回undefined。
* attr($properties) 对于所有匹配到的元素设置对应属性。
* attr($key, $value) 对于匹配到的元素设置一个属性和对应值。
* attr($key, $fn) 对于匹配到的元素设置一个属性和需要计算的值。
* removeAttr($name) 对匹配到的元素移除给定名称的属性。
* addClass($class) 对匹配到的元素添加一个给定的类。
* hasClass($class) 如果有至少一个匹配到的元素包含给定的类则返回true。
* removeClass($class) 对匹配到的元素移除给定名称的类。
* toggleClass($class) 对匹配到的元素，如果类不存在则添加，如果存在则移除。

### HTML获取

* html() 获取第一个匹配到的元素的html内容（innerHTML）。这个方法不适用于XML文本（但适用于XHTML。）
* html($val) 对匹配到的元素设置html内容。这个方法不适用于XML文本（但适用于XHTML。）

### text获取

* text() 获取匹配到的所有元素的文本内容。
* text($val) 对匹配到的所有元素设置文本内容。

### Value 获取

* val() 获取匹配到的第一个元素的value属性的值。
* val($val) 对匹配到的元素设置value值。val($val) 所有的Checks, selects, radio buttons, checkboxes,和select options都会设置相应给定的值。

## 2 参考

* [文档](https://blog.csdn.net/summerxiachen/article/details/78681674)






