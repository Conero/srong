const fs = require('fs');
let content = fs.readFileSync('./tests/data/province.csv');
// console.log(content.toString());
let data = content.toString().split("\n");
let len = data.length;
let sqls = [];
for (let i = 0; i < len; i++) {
    let s = data[i];
    // s = s.replace(/s/g, '');
    //if(i>2){break;}
    if(i === 0){
        continue;
    }
    let matches = s.match(/"[^"]+"/g);
    if(matches){
        let mLen = matches.length;
        for (let j = 0; j < mLen; j++) {
            let s1 = matches[j];
            let r1 = s1.replace(/("|,)/g, '');
            s = s.replace(s1, r1)
        }
    }
    let dd = s.split(',');
    let ddLen = dd.length;
    for (let n = 0; n < ddLen; n++) {
        let v1 = dd[n];
        if(v1){
            //v1 = v1.replace(/'/g, "\\'");
            v1 = v1.replace(/'/g, "''");
            v1 = `'${v1}'`;
        }else{
            v1 = 'null';
        }
        dd[n] = v1;
    }
    sqls.push('insert into province (name, cname, area, capital, ct_city, ct_county, ct_area, ct_village, ct_cho, country) values('+
        dd.join(',')+');'+"\n");
}

// ------------
function sqlite(){
    console.log('生成 province 表数据插入语句');
    //console.log(sqls);
    let sql = sqls.join('');
    sql = `delete from province;` + "\n" + sql;
    console.log(sql);
    fs.writeFileSync('./tests/data/sqlite.province.sql', sql);
}
sqlite();