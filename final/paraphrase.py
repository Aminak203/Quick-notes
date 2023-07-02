import sys
import requests
from urllib.parse import quote
from json import loads

API_URL = "https://quillbot.com/api/singleParaphrase"
PARAMS = "?userID=N/A&text={}&strength={}&autoflip={}&wikify={}&fthresh={}"


def setup_session():
    session = requests.Session()
    session.headers.update(
        {
            "User-Agent": "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0",
            "Content-Type": "application/text"
        }
    )
    return session


def get_parameterized_url(text):
    url_encoded_text = quote(text)
    autoflip = "true"
    fthresh = "4"
    strength = "5"
    wikify = "9"
    url = API_URL + PARAMS.format(url_encoded_text, strength, autoflip, wikify, fthresh)
    return url


def paraphrasor(url, session):
    cookies = {
        # Replace these cookies with your own cookies or use an API key if available
    }

    req = session.get(url, cookies=cookies)
    if req.status_code == 200:
        json_text = loads(req.text)
        json_text = json_text[0] if len(json_text) == 1 else json_text

        paras = [key for key in json_text if key.startswith("paras")]
        texts = list(
            {text.get("alt") for para in paras for text in json_text[para]}
        )

        return texts[0] if texts else None
    return None


def main(input_text):
    session = setup_session()
    if len(input_text) > 700:
        print("line should be less than 700 characters, %s" % input_text)
    else:
        url = get_parameterized_url(input_text)
        paraphrased_text = paraphrasor(url, session)
        if paraphrased_text:
            print(paraphrased_text)
        else:
            print("Error: Could not paraphrase the text")


if __name__ == "__main__":
    if len(sys.argv) > 1:
        input_text = sys.argv[1]
        main(input_text)
    else:
        print("Error: No input text provided")
