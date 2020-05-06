const BceClient=require('bce-sdk-js');

const config = {
    endpoint: 'http://bcd.baidubce.com',
    credentials: {
        ak: '百度云ak',
        sk: '百度云sk'
    }
};


var data =  {
  "domain" : "你的域名",
  "pageNo" : 1,
  "pageSize" : 100
}

let client = new BceClient.BcdClient(config);

client.domainResolveList(data)
    .then(response => {
      // console.log("response==",response)
      var body = response.body
      var result = body.result
      if(result && result.length>0){
        for(var i=0;i<result.length;i++){
          var item = result[i]

          if(item.domain=='qinius'){
            var newItem = item
            newItem.rdata = '指向百度云服务器的cname地址，也就是shell脚本所在的服务器'
            newItem.status = undefined
            newItem.rdType = 'CNAME'
            console.log("newItem==",newItem)
            client.domainResolveEdit(newItem)
                .then(itemresponse => {
                  console.log("itemresponse==",itemresponse)
                })    // 成功
                .catch(error => console.error("error===",error));      // 失败
            break;
          }

        }

      }
    })    // 成功
    .catch(error => console.error("error===",error));      // 失败
