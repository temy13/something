from glob import glob
import zipfile
import os
import os.path
import traceback

def extract_str(fn, code):
    dir = fn.replace("zip","")
    with zipfile.ZipFile(fn) as existing_zip:
        existing_zip.extractall(dir)

    d = {}
    return extract_dir(dir, d)


def extract_dir(dir, d):
    for path in glob(dir + "/*"):
        if os.path.isdir(path):
            d = extract_dir(path, d)
            continue
        ext = path.split(".")[-1]
        if ext not in ["xml", "htm", "xsd", "xbrl", "csv"]:
            print(ext)
            continue
        d[path] = extract_file(path)
    return d


def extract_file(path):
    try:
        s = ""
        f = open(path)
        if path.endswith("xml"):
            s = xml_to_s(f.read())
        elif path.endswith("htm"):
            s = html_to_s(f.read())
        elif path.endswith("xsd"):
            s = xsd_to_s(f.read())
        elif path.endswith("xbrl"):
            s = xbrl_to_s(f.read())
        elif path.endswith("csv"):
            s = csv_to_s(f.read())
        f.close()
    except:
        print(traceback.format_exc())
        print(path)

    return s

def xml_to_s(xml):
    pass

def html_to_s(html):
    pass

def xsd_to_s(xsd):
    pass

def xbrl_to_s(xbrl):
    pass

def csv_to_s(csv):
    pass
