var messages = {
        accepted         : ":attribute 必须接受。",
        alpha            : ":attribute 只能由字母组成。",
        alpha_dash       : ":attribute 只能由字母、数字和斜杠组成。",
        alpha_num        : ":attribute 只能由字母和数字组成。",
        array            : ":attribute 必须是一个数组。",
        object           : ":attribute 必须是一个对象。",
        between          : {
           numeric : ":attribute 必须介于 :min - :max 之间。",
           string  : ":attribute 必须介于 :min - :max 个字符之间。",
           array   : ":attribute 必须只有 :min - :max 个单元。",
        },
        confirmed        : ":attribute 两次输入不一致。",
        different        : ":attribute 和 :other 必须不同。",
        digits           : ":attribute 必须是 :digits 位的数字。",
        digits_between   : ":attribute 必须是介于 :min 和 :max 位的数字。",
        email            : ":attribute 不是一个合法的邮箱。",
        allow            : "已选的属性 :attribute 非法。",
        integer          : ":attribute 必须是整数。",
        ip               : ":attribute 必须是有效的 IP 地址。",
        max              : {
          numeric : ":attribute 不能大于 :max。",
          string  : ":attribute 不能大于 :max 个字符。",
          array   : ":attribute 最多只有 :max 个单元。",
        },
        min              : {
          numeric : ":attribute 必须大于等于 :min。",
          string  : ":attribute 至少为 :min 个字符。",
          array   : ":attribute 至少有 :min 个单元。",
        },
        not_in           : "已选的属性 :attribute 非法。",
        numeric          : ":attribute 必须是一个数字。",
        regex            : ":attribute 格式不正确。",
        required         : ":attribute 不能为空。",
        required_if      : "当 :other 为 :value 时 :attribute 不能为空。",
        required_with    : "当 :values 存在时 :attribute 不能为空。",
        required_without : "当 :values 不存在时 :attribute 不能为空。",
        same             : ":attribute 和 :other 必须相同。",
        size             : {
          numeric : ":attribute 大小必须为 :size。",
          string  : ":attribute 必须是 :size 个字符。",
          array   : ":attribute 必须为 :size 个单元。",
        },
        url              : ":attribute 格式不正确。"
  };

window['validator.messages'] = messages;