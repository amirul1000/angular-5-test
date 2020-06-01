import { Injectable } from '@angular/core';

import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/operator/do';

const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};


@Injectable()
export class DataService {

  constructor(public http: HttpClient) { }

  getTestList():Observable<any>
  {
        return this.http.get('http://localhost/angulartest/rest-api/server.php?cmd=testdata');
  }

  getEditedData(id:string):Observable<any>
  {
        return this.http.get('http://localhost/angulartest/rest-api/server.php?cmd=testediteddata&id='+id);
  }

  addTest(id:string,post_data:any):Observable<any>
  {
        if(id==undefined)
        {
          id='';
        }
        let body = JSON.stringify(post_data);
        return this.http.post('http://localhost/angulartest/rest-api/server.php?cmd=addtestdata&id='+id, body, httpOptions);
  }

  deleteTest(delete_data:any):Observable<any>
  {
        let body = JSON.stringify(delete_data);
        return this.http.post('http://localhost/angulartest/rest-api/server.php?cmd=deletetestdata', body, httpOptions);
  }

}
