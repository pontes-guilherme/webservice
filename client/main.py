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
			print ("==== Digite todos os dados corretamente ====\n")

			ida_volta = input ("Gostaria de comprar as passagens de ida e volta? S = Sim, N = Não \n")

			if (ida_volta.lower() == 's'):
				iteracoes = 2
			else:
				iteracoes = 1

			for i in range (iteracoes):
				if i == 0:
					print ("====== Comprando a passagem de ida ====== \n")
				else:
					print ("====== Comprando a passagem de volta ====== \n")

				passagem_id = input ("Digite o ID da passagem: \n")
				cartao = input ("Digite o número do cartão: \n")
				parcelas = input ("Digite o número de parcelas: \n")
				n_pessoas = input ("Digite o número de passagens desejadas: \n")
				json = {"id" : str (passagem_id) , "cartao" : str(cartao), "parcelas": str(parcelas), "n_pessoas": str(n_pessoas)}

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
			print ("==== Digite todos os dados corretamente ====\n")

			hotel_id = input ("Digite o ID do hotel: \n")
			cartao = input ("Digite o número do cartão: \n")
			parcelas = input ("Digite o número de parcelas: \n")
			n_pessoas = input ("Digite o número de quartos desejadas: \n")

			json = {"id" : str(hotel_id), "cartao" : str(cartao), "parcelas": str(parcelas), "n_pessoas": str(n_pessoas)}

			req.handle_list_response(req.send_post(req.URL_POST_HOSPEDAGEM, json=json))
			func.enter_to_continue()

		elif opt == "7": #info compra passagem
			id = input("Digite o Código:\n")
			req.handle_list_response(req.send_get(req.URL_GET_COMPRA_PASSAGEM + '/' + id))
			func.enter_to_continue()

		elif opt == "8": #info compra passagem
			id = input("Digite o Código:\n")
			req.handle_list_response(req.send_get(req.URL_GET_COMPRA_HOSPEDAGEM + '/' + id))
			
			func.enter_to_continue()

		else:
			print("Opção inválida")
			func.enter_to_continue()

if __name__ == '__main__':
	main()
