import { Injectable } from '@angular/core';
import 'rxjs/add/operator/toPromise';
import { LocalStorageService } from 'angular-2-local-storage';
import { Headers, Http, Response } from '@angular/http';
import { Cliente } from '../model/cliente';
import { LinhaDeItem } from '../model/linhaDeItem';
import { Divida } from '../model/divida';
import { Impressao } from '../model/impressao';


@Injectable()
export class VendaService {

  private headers = new Headers({ 'Content-Type': 'application/json' });
  private impressao: Impressao;

  constructor(private storage: LocalStorageService, private http: Http) {

  }

  concluirCompra(idCliente: number, idUser: number, linhaDeItem: LinhaDeItem[], divida: Divida, valor: any): Promise<any> {

    this.impressao = new Impressao();

    if (divida.tipoVenda == "5") {
      this.impressao.tipoPagamento = "Cheque";
    } else if (divida.tipoVenda == "4") {
      this.impressao.tipoPagamento = "Pendência";
    } else if (divida.tipoVenda == "3") {
      this.impressao.tipoPagamento = "Cartão/Crédito";
    } else if (divida.tipoVenda == "2") {
      this.impressao.tipoPagamento = "Cartão/Débito";
    } else {
      this.impressao.tipoPagamento = "Dinheiro";
    }
    this.impressao.idUsuario = idUser;
    this.impressao.desconto = valor.desconto;
    this.impressao.total = valor.total;
    this.impressao.subtotal = valor.subtotal;
    this.impressao.linhaDeItem = linhaDeItem;
    this.impressao.parcelas = divida.parcelasAPagar;

    return this.http
      .post('http://dsoutlet.com.br/apiDsoutlet/venda.php', JSON.stringify({ idCliente, idUser, linhaDeItem, divida }), { headers: this.headers })
      .toPromise()
      .then(res => this.extractAddData(res))
      .catch(this.handleError);
  }

  private extractAddData(res: Response) {
    let data = res.json();
    if (typeof data[0] == "string") {
      this.impressao.idVenda = data[0];
      try {
        this.storage.set('venda', this.impressao);
      } catch (e) {

      }
    }
    return data;
  }

  private handleError(error: any) {
    return false;
  }

  getVenda(): Impressao {

    let venda = <Impressao>this.storage.get('venda');
    if (venda != null) {
      return venda;
    } else if (this.impressao != null) {
      return this.impressao;
    } else {
      return new Impressao();
    }
  }

}
