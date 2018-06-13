#import request, os
from Functions import Functions as func
from Requests import Requests as req

def main():

	while(True):
		opt = func.menu()

		if opt == "1": #lista passagens
			# GET /passagem
			req.handle_list_response(req.send_get(req.URL_GET_PASSAGEM))
			func.enter_to_continue()
		elif opt == "2": #busca de passagens
			# GET /passagem/{key}/{value}
			key = input("Digite o campo que deseja pesquisar:\n")
			value = input("Digite o valor do campo de pesquisa:\n")

			if (key is not "" and value is not ""):
				req.handle_list_response(req.send_get(req.URL_GET_PASSAGEM + '/' + key + '/' + value))
			else:
				print("O campo e o valor de pesquisa devem ser informados")	

			func.enter_to_continue()

		elif opt == "3": #info passagem
			# GET /passagem/{id}
			try:
				passagem_id = int(input("Digite o ID:\n").strip())
			except:	
				print("Um id numérico deve ser digitado!")	
				func.enter_to_continue()
				continue

			req.handle_list_response(req.send_get(req.URL_GET_PASSAGEM + '/' + str(passagem_id)))
			func.enter_to_continue()

		elif opt == "4": #comprar passagem
			# POST /passagem/comprar
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

		elif opt == "5": #lista hospedagens
			#GET /hospedagem
			req.handle_list_response(req.send_get(req.URL_GET_HOSPEDAGEM))
			func.enter_to_continue()

		elif opt == "6":
			# GET /hospedagem/{key}/{value}
			key = input("Digite o campo que deseja pesquisar:\n")
			value = input("Digite o valor do campo de pesquisa:\n")

			if (key is not "" and value is not ""):
				req.handle_list_response(req.send_get(req.URL_GET_HOSPEDAGEM + '/' + key + '/' + value))
			else:
				print("O campo e o valor de pesquisa devem ser informados")	

			func.enter_to_continue()

		elif opt == "7": #info hospedagem
			#GET /hospedagem/{id}
			try:
				hospedagem_id = int(input("Digite o ID:\n").strip())
			except:	
				print("Um id numérico deve ser digitado!")	
				func.enter_to_continue()
				continue
				
			req.handle_list_response(req.send_get(req.URL_GET_HOSPEDAGEM + '/' + str(hospedagem_id)))	
			func.enter_to_continue()

		elif opt == "8": #comprar hospedagem
			#POST /hospedagem/comprar
			print ("==== Digite todos os dados corretamente ====\n")

			hotel_id = input ("Digite o ID do hotel: \n")
			cartao = input ("Digite o número do cartão: \n")
			parcelas = input ("Digite o número de parcelas: \n")
			n_pessoas = input ("Digite o número de quartos desejadas: \n")

			json = {"id" : str(hotel_id), "cartao" : str(cartao), "parcelas": str(parcelas), "n_pessoas": str(n_pessoas)}

			req.handle_list_response(req.send_post(req.URL_POST_HOSPEDAGEM, json=json))
			func.enter_to_continue()

		elif opt == "9": #info compra passagem
			#GET /compras/passagem/{codigo}
			id = input("Digite o Código:\n")
			if (id is not ""):
				req.handle_list_response(req.send_get(req.URL_GET_COMPRA_PASSAGEM + '/' + id))
			else:
				print("Um código deve ser digitado")

			func.enter_to_continue()

		elif opt == "10": #info compra passagem
			#GET /compras/hospedagem/{codigo}
			id = input("Digite o Código:\n")
			if (id is not ""):
				req.handle_list_response(req.send_get(req.URL_GET_COMPRA_HOSPEDAGEM + '/' + id))
			else:
				print("Um código deve ser digitado")

			func.enter_to_continue()

		else:
			print("Opção inválida")
			func.enter_to_continue()

if __name__ == '__main__':
	main()
