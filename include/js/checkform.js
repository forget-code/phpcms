var Check = function(name) {
    this.formName = name;
    this.errMsg = new Array();
   
    /**
     * 检查用户是否输入了内容
     *
     * @param:  controlId   表单元素的ID
     * @param:  msg         错误提示信息
     */
    this.must = function(controlId, msg) {
        var obj = document.forms[this.formName].elements[controlId];
        if (typeof(obj) == "undefined" || Common.trim(obj.value) == "")
        {
            this.addErrorMsg(msg);
        }
    };

    /**
     * 检查用户输入的是否为合法的邮件地址
     *
     * @param:  controlId   表单元素的ID
     * @param:  msg         错误提示信息
     * @param:  required    是否必须
     */
    this.isemail = function(controlId, msg, required) {
        var obj = document.forms[this.formName].elements[controlId];
        obj.value = Common.trim(obj.value);

        if (!required && obj.value == '')
        {
            return;
        }

        if (!Common.isemail(obj.value))
        {
            this.addErrorMsg(msg);
        }
    }
    
    /**
     * 检查两个表单元素的值是否相等
     * 
     * @param: fstControl   表单元素的ID
     * @param: sndControl   表单元素的ID
     * @param: msg         错误提示信息
     */
    this.equal = function(fstControl, sndControl, msg)
    {
        var fstObj = document.forms[this.formName].elements[fstControl];
        var sndObj = document.forms[this.formName].elements[sndControl];
        if (fstObj != null && sndObj != null)
        {
            if (fstObj.value == '' || fstObj.value != sndObj.value)
            {
                this.addErrorMsg(msg);
            }
        }
    }
    
        /**
     * 检查两个表单元素的值不得相等
     * 
     * @param: fstControl   表单元素的ID
     * @param: sndControl   表单元素的ID
     * @param: msg         错误提示信息
     */
    this.notequal = function(fstControl, sndnum, msg)
    {
        var fstObj = document.forms[this.formName].elements[fstControl];
        if (fstObj != null)
        {
            if (fstObj.value == sndnum)
            {
                this.addErrorMsg(msg);
            }
        }
    }

	 /**
     * 检查前一个表单元素是否大于后一个表单元素
     * 
     * @param: fstControl   表单元素的ID
     * @param: sndControl   表单元素的ID
     * @param: msg         错误提示信息
     */
    this.great = function(fstControl, sndControl, msg)
    {
        var fstObj = document.forms[this.formName].elements[fstControl];
        var sndObj = document.forms[this.formName].elements[sndControl];
        
        if (fstObj != null && sndObj != null)
        {
            if (fstObj.value <= sndObj.value)
            {
                this.addErrorMsg(msg);
            }
        }
    }

    /**
     * 检查输入的内容是否是一个数字
     * 
     * @param:  controlId   表单元素的ID
     * @param:  msg         错误提示信息
     * @param:  required    是否必须
     */
    this.isnumber = function(controlId, msg, required) {
        var obj = document.forms[this.formName].elements[controlId];
        obj.value = Common.trim(obj.value);

        if (obj.value == '' && !required)
        {
            return;
        }
        else
        {
            if (!Common.isnumber(obj.value))
            {
                this.addErrorMsg(msg);
            }
        }
    }

    /**
     * 检查输入的内容是否是一个整数
     * 
     * @param:  controlId   表单元素的ID
     * @param:  msg         错误提示信息
     * @param:  required    是否必须
     */
    this.isint = function(controlId, msg, required) {
        var obj = document.forms[this.formName].elements[controlId];
        obj.value = Common.trim(obj.value);

        if (obj.value == '' && !required)
        {
            return;
        }
        else
        {
            if (!Common.isint(obj.value)) this.addErrorMsg(msg);
        }
    }
	
	 /**
     * 检查输入的内容是否是一个整数
     * 
     * @param:  controlId   表单元素的ID
     * @param:  msg         错误提示信息
     * @param:  required    是否必须
     */
    this.isnulloption = function(controlId, msg) {
        var obj = document.forms[this.formName].elements[controlId];

        obj.value = Common.trim(obj.value);

        if (obj.value > '0' )
        {
            return;
        }
        else
        {
            this.addErrorMsg(msg);
        }
    }


     /**
     * 检查输入的内容是否是"2006-11-12 12:00:00"格式
     * 
     * @param:  controlId   表单元素的ID
     * @param:  msg         错误提示信息
     * @param:  required    是否必须
     */
    this.istime = function(controlId, msg, required) {
        var obj = document.forms[this.formName].elements[controlId];
        obj.value = Common.trim(obj.value);

        if (obj.value == '' && !required)
        {
            return;
        }
        else
        {
            if (!Common.isdatetime(obj.value)) 
            this.addErrorMsg(msg);
        }
    }

    /**
     * 检查指定的checkbox是否选定
     * 
     * @param:  controlId   表单元素的name
     * @param:  msg         错误提示信息
     */
    this.requiredcheckbox = function(chk, msg) {
        var obj = document.forms[this.formName].elements[controlId];
        var checked = false;

        for(var i = 0; i < objects.length; i++) {
            if (objects[i].type.toLowerCase() != "checkbox") continue;
            if (objects[i].checked)
            {
                checked = true;
                break;
            }
        }

        if (!checked) this.addErrorMsg(msg);
    }

    this.passed = function() {
        if (this.errMsg.length > 0)
        {
            var msg = "";
            for (i = 0; i < this.errMsg.length; i++)
            {
              msg += "- " + this.errMsg[i] + "\n";
            }

            alert(msg);
            return false;
        }
        else
        {
          return true;
        }
    }

    /**
     * 增加一个错误信息
     * 
     * @param:  str
     */
    this.addErrorMsg = function(str) {
        this.errMsg.push(str);
    }
}
/**
* 帮助信息的显隐函数  
 */
function showNotice(objId)
{
      var obj = document.getElementById(objId);

    if (obj)
    {
        if (obj.style.display != "block")
        {
            obj.style.display = "block";
        }
        else
        {
            obj.style.display = "none";
        }
    }
}

function addItem(src, dst)
{
    for(var x = 0; x < src.length; x++)
    {
        var opt = src.options[x];
        if (opt.selected && opt.value != '')
        {
            var newOpt = opt.cloneNode(true);
            newOpt.className = '';
            dst.appendChild(newOpt);
        }
    }

    src.selectedIndex = -1;
}

function delItem(ItemList)
{
    for(var x=ItemList.length-1;x>=0;x--)
    {
        var opt = ItemList.options[x];
        if (opt.selected)
        {
            ItemList.options[x] = null;
        }
    }
}
function joinItem(ItemList)
{
    var OptionList = new Array();
    for (var i=0; i<ItemList.length;i++)
    {
        OptionList[OptionList.length] = ItemList.options[i].text +"|"+ ItemList.options[i].value;
    }
    return OptionList.join(",");
}
