var errorBinder:string=" ";
/*const Joi = require('@hapi/joi');
const schema = Joi.object({
    username: Joi.string()
        .alphanum()
        .min(3)
        .max(30)
        .required(),

    password: Joi.string()
        .pattern(new RegExp('^[a-zA-Z0-9]{3,30}$')),

    repeat_password: Joi.ref('password'),

    access_token: [
        Joi.string(),
        Joi.number()
    ],

    birth_year: Joi.number()
        .integer()
        .min(1900)
        .max(2013),

    email: Joi.string()
        .email({ minDomainSegments: 2, tlds: { allow: ['com', 'net'] } })
})
    .with('username', 'birth_year')
    .xor('password', 'access_token')
    .with('password', 'repeat_password');*/

export function validate(email:string):Promise<string> {
    return new Promise((resolve,reject)=>{
        if (email.split("@")[1].toString().localeCompare("student.emi.ac.ma") == 0) {
            resolve("All good for email");
            //if(schema.validate())
        }else {
            next("Not the good smtp server it must be like student.emi.ac.ma",true);
        }
        reject(errorBinder);
    });
}

function next(error:string,last:boolean):string{

    if(last){
        errorBinder=errorBinder.concat(error);
        return errorBinder;
    }else {
        errorBinder=errorBinder.concat(error);
    }
}