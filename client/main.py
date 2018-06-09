#import request, os
from Functions import Functions as func
from Requests import Requests as req

def main():

    while(True):
        opt = func.menu()

        if opt == "1": #lista passagens
            req.handle_list_response(req.send_get(req.URL_GET_PASSAGEM))
            func.enter_to_continue()

        elif opt == "2": #info passagem
            passagem_id = input("Digite o ID:\n")
            req.handle_list_response(req.send_get(req.URL_GET_PASSAGEM + '/' + passagem_id))
            func.enter_to_continue()

        elif opt == "3": #comprar passagem
            json = {'id': '1', 'n_pessoas': '10', 'cartao': 'xxx', 'parcelas':'12'}  
            req.handle_list_response(req.send_post(req.URL_POST_PASSAGEM, json=json))
            func.enter_to_continue()

        elif opt == "4": #lista hospedagens
            req.handle_list_response(req.send_get(req.URL_GET_HOSPEDAGEM))
            func.enter_to_continue()

        elif opt == "5": #info hospedagem
            hospedagem_id = input("Digite o ID:\n")
            req.handle_list_response(req.send_get(req.URL_GET_HOSPEDAGEM + '/' + hospedagem_id))
            func.enter_to_continue()

        elif opt == "6": #comprar hospedagem
            json = {'id': '1', 'n_pessoas': '10', 'cartao': 'xxx', 'parcelas':'12'}   
            req.handle_list_response(req.send_post(req.URL_POST_HOSPEDAGEM, json=json))
            func.enter_to_continue()

        else:
            print("Opção inválida")
            func.enter_to_continue()

if __name__ == '__main__':
    main()
