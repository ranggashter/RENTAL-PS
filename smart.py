import requests
import subprocess
import sys

def cek_status(api_url, tv_ip):
    try:
        response = requests.get(api_url)
        data = response.json()
        print("Data API:", data)  # cek apakah API mengembalikan data yang benar

        if data["status"] == "off":
            print("Mematikan TV...")
            print(f"Koneksi ke ADB: {tv_ip}")
            subprocess.run(["adb", "connect", tv_ip])
            subprocess.run(["adb", "shell", "input keyevent 26"])  # Power OFF
            subprocess.run(["adb", "disconnect", tv_ip])
        else:
            print("TV tetap menyala")

    except Exception as e:
        print("Error:", e)

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Penggunaan: python smart.py <api_url> <tv_ip>")
    else:
        api_url = sys.argv[1]
        tv_ip = sys.argv[2]
        cek_status(api_url, tv_ip)
