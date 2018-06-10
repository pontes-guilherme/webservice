import requests as req
from Functions import Functions as func

class Requests:

    URL_GET_PASSAGEM = 'http://localhost/pacotes/server/passagem'
    URL_POST_PASSAGEM = 'http://localhost/pacotes/server/passagem/comprar'

    URL_GET_HOSPEDAGEM = 'http://localhost/pacotes/server/hospedagem'
    URL_POST_HOSPEDAGEM = 'http://localhost/pacotes/server/hospedagem/comprar'

    URL_GET_COMPRA_PASSAGEM = 'http://localhost/pacotes/server/compras/passagem'
    URL_GET_COMPRA_HOSPEDAGEM = 'http://localhost/pacotes/server/compras/hospedagem'

    @staticmethod
    def send_post(addr, json):
        """Manda um JSON via POST para uma url
        
        Arguments:
            addr {string} -- Url para a qual o POST será enviado
            json {dictionary} -- JSON com o conteúdo 
        
        Returns:
            tuple -- Tupla contendo status code e o JSON de resposta
        """

        r = req.post(addr, json=json)
        return r.status_code, r.json()

    @staticmethod
    def send_get(addr,json=None):
        """Manda GET para uma url
        
        Arguments:
            addr {string} -- Url para a qual o GET será enviado
        
        Returns:
            tuple -- Tupla contendo status code e o JSON de resposta
        """
        
        r = req.get(addr, json=json)
        return r.status_code, r.json()

    @staticmethod
    def handle_list_response(response):
        """Manipula a resposta obtida em forma de uma lista.
        A manipulação é feita através da impressâo da mensagem, caso
        seu status seja 200 OK. Caso contrário, somente o código de
        status é returnado
        
        Arguments:
            response {tuple} -- Tupla contendo status code e JSON
        """

        status_code, json = response
        
        if status_code != 200:
            print("Status code %s" % status_code)

        func.print_dict_recursively(json)

        #return json 
