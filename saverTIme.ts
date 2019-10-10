import { Injectable } from '@angular/core';
import "rxjs/add/operator/map";
import { Http, Headers,RequestOptions} from '@angular/http';

@Injectable({
  providedIn: 'root'
})
export class GlobalService {
  restApi = 'https://localhost:80/au-instacollect/API/apis.php';
  loader=false
  constructor(public http:Http) { }
  public post( url, body, successCallback, failedCallback, loader = true, text = "Please wait..." ) {
    let headers = new Headers({
      "Content-Type": "application/x-www-form-urlencoded"
    });

    let options = new RequestOptions({
      headers: headers
    });

    if (loader) {
      this.loader = true;
    }

    this.http.post(url, body, options).map(res => res.json()).subscribe(
        data => {
          this.loader = false;
          successCallback(data);
          //loading.dismiss();
          //console.log(data);
        },
        err => {
          this.loader = false;
          failedCallback(err);
          //loading.dismiss();
        }
      );
  }
  // public alert(message: string, action: string) {
  //   this.snackBar.open(message, action, {
  //     duration: 2000,
  //     verticalPosition:'top'
  //   });
  // }
  
  // public setDashBoard(){
  //   if(this.userDetails.type =='workstation'){
  //     //this..user_type = 'workstation'
  //     this.links=['Home','action'];
  //   }else if(this.userDetails.type =='vendor'){
  //     //this.global.user_type = 'vendor'
  //     this.links = ['Home','History'];
  //   }
  // }

//   public get( url, successCallback, failedCallback, loader = true, text = "Please wait..." ) {
    
//     if (loader) {
//       this.loader = true;
//     }

//     this.http.get(url).map(res => res.json()).subscribe(
//         data => {
//           this.loader = false;
//           successCallback(data);
//           //loading.dismiss();
//         },
//         err => {
//           this.loader = false;
//           failedCallback(err);
//           //loading.dismiss();
//         }
//       );
  
//   public navigate(page) {
//     this.router.navigate([page]);
//   }
// }

}
